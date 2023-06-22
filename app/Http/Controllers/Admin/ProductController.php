<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MediaOrderType;
use App\Http\Controllers\Controller;
use App\Repositories\NodeRepositoryImp;
use App\Repositories\MediaRepositoryImp;
use App\Enums\PriceType;
use App\Repositories\TeacherRepositoryImp;
use App\Repositories\PermissionRepositoryImp;
use App\Repositories\NodeMediaRepositoryImp;

class ProductController extends Controller
{
	/** @var NodeRepositoryImp $nodeRepo */
	private $nodeRepo;

	/** @var NodeMediaRepositoryImp $nodeMediaRepo */
	private $nodeMediaRepo;

	/** @var MediaRepositoryImp $mediaRepo */
	private $mediaRepo;

	/** @var TeacherRepositoryImp $teacherRepo */
	private $teacherRepo;

	/** @var PermissionRepositoryImp $permissionRepo */
	private $permissionRepo;

	public function __construct(NodeRepositoryImp $nodeRepo, MediaRepositoryImp $mediaRepo, TeacherRepositoryImp $teacherRepo, PermissionRepositoryImp $permissionRepo, NodeMediaRepositoryImp $nodeMediaRepo)
	{
		$this->nodeRepo = $nodeRepo;
		$this->mediaRepo = $mediaRepo;
		$this->teacherRepo = $teacherRepo;
		$this->permissionRepo = $permissionRepo;
		$this->nodeMediaRepo = $nodeMediaRepo;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index(): \Illuminate\View\View
	{
		/** @var \Illuminate\Pagination\LengthAwarePaginator $products */
		$products = $this->nodeRepo->getPaginatedProducts(10, 'id', 'desc', ['prices', 'medias', 'ownerable']);

		foreach ($products as $product) {
			/** @var \App\Models\Node $product */
			$product->fromRootToNode = $this->nodeRepo->getFromRootToParent($product)->sortBy('id')->pluck('title')->toArray();
			$product->countOfUseInPackages = $this->nodeRepo->countOfUseProductInPackages($product);
			$this->nodeRepo->addPriceToAttributes($product);
		}
		return view('admin.product.index', [
			'products' => $products
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
	 */
	public function create()
	{
		$groups = $this->teacherRepo->getGroupCanBeAssignToNode();
		if ($groups->isEmpty()) {
			session()->flash('alert', [
				'type' => 'warning',
				'message' => 'هیچ گروهی از مربیان ثبت نشده است.',
			]);
			return redirect(route('admin.product.index'));
		}
		return view('admin.product.create', [
			'groups' => $groups,
			'root_nodes' => $this->nodeRepo->getRoots()
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Admin\ProductRequest  $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(\App\Http\Requests\Admin\ProductRequest $request): \Illuminate\Http\RedirectResponse
	{
		try {
			/** @var \App\Models\Node $parent */
			$parent = $this->nodeRepo->find((int) $request->get('category'));

			/** @var \App\Models\Node $product */
			$product = $this->nodeRepo->addChildNode([
				'title' => $request->get('title'),
				'description' => $request->get('description'),
				'is_product' => true,
				'ownerable_type' => \App\Models\TeacherGroup::class,
				'ownerable_id' => (int) $request->get('group'),
				'status' => ($request->get('status') === 'publish') ? 'publish' : 'disable',
				'score' => $request->get('score')
			], $parent);

			// save price
			$this->nodeRepo->setPriceForNode($product, [
				[
					'type' => PriceType::CASH,
					'amount' => (float) $request->price
				],
				[
					'type' => PriceType::COIN,
					'amount' => $request->price_coin
				],
				[
					'type' => PriceType::DVD,
					'amount' => $request->dvd_price
				],
				[
					'type' => PriceType::FLASH,
					'amount' => $request->flash_price
				]
			]);

			session()->flash('alert', [
				'type' => 'success',
				'message' => 'با موفقیت انجام شد.',
			]);
		} catch (\Exception $e) {
			session()->flash('alert', [
				'type' => 'danger',
				'message' => 'متاسفانه خطایی رخ داده است.',
			]);
		}
		return redirect(route('admin.product.index'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\View\View
	 */
	public function edit(int $id): \Illuminate\View\View
	{
		/** @var \Illuminate\Database\Eloquent\Collection $groups */
		$groups = $this->teacherRepo->getGroupCanBeAssignToNode();
		if ($groups->isEmpty()) {
			setDangerAlertSession('هیچ گروهی از مربیان ثبت نشده است.');
			return redirect(route('admin.product.index'));
		}

		/** @var \App\Models\Node $product */
		$product = $this->nodeRepo->findOneOrFail($id);
		$product->load(['medias', 'prices']);

		// First Get Items Which Order Column's Not Null
		/** @var \Illuminate\Database\Eloquent\Collection $productMediaHaveOrder */
		// $productMediaHaveOrder =  $product
		// 	->medias()
		// 	->wherePivot('order', '!=', null)
		// 	->wherePivot('order', '>', 0)
		// 	->orderBy('order', 'ASC')
		// 	->get();

		// /** @var \Illuminate\Database\Eloquent\Collection $productMediaWithoutOrder */
		// $productMediaWithoutOrder = $product
		// 	->medias()
		// 	->wherePivot('order', null)
		// 	->wherePivot('order', '>', 0)
		// 	->get();

		// $productMediaHaveOrder = $productMediaHaveOrder->merge($productMediaWithoutOrder);

		$data = [
			'product' => $product,
			// 'product_media_count' => $product->medias()->count(),
			// 'product_medias' => $productMediaHaveOrder,
			'root_nodes' => $this->nodeRepo->getRoots(),
			'package_owner' => $product->ownerable ?? null,
			'groups' => $groups,
		];

		foreach ($product->prices as $price) {
			$data['prices'][$price->type] = $price->amount;
		}

		if ($iconImage = $this->nodeRepo->getNodeIconMedia($product)) {
			$data['iconImage'] = [
				'path' => $product->productMediaPath() . $iconImage->path,
				'mediaId' => $iconImage->id
			];
		}
		if ($backgroundImage = $this->nodeRepo->getNodeBackgroundMedia($product)) {
			$data['backgroundImage'] = [
				'path' => $product->productMediaPath() . $backgroundImage->path,
				'mediaId' => $backgroundImage->id
			];
		}
		if ($indexImage = $this->nodeRepo->getNodeIndexMedia($product)) {
			$data['indexImage'] = [
				'path' => $product->productMediaPath() . $indexImage->path,
				'mediaId' => $indexImage->id
			];
		}
		if ($productFile = $this->nodeRepo->getProductFile($product)) {
			$data['productFile'] = [
				'path' => $product->productMediaPath() . $productFile->path,
				'mediaId' => $productFile->id
			];
		}
		return view('admin.product.edit', $data);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\Admin\ProductRequest  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(\App\Http\Requests\Admin\ProductRequest $request, $id): \Illuminate\Http\RedirectResponse
	{
		try {
			/** @var \App\Models\Node $product */
			$product = $this->nodeRepo->find($id);
			$this->nodeRepo->update([
				'title' => $request->get('title'),
				'description' => $request->get('description'),
				'ownerable_type' => \App\Models\TeacherGroup::class,
				'ownerable_id' => (int) $request->get('group'),
				'status' => ($request->get('status') === 'publish') ? 'publish' : 'disable',
				'score' => $request->get('score')
			], $id);

			// update category
			if ($request->get('category') !== $product->parent_id) {
				$this->nodeRepo->moveNode($product, $this->nodeRepo->find((int) $request->get('category')));
			}

			// update price
			$product->load('prices');
			$this->nodeRepo->updateCashPriceOfNode($product, $request->get('price'));
			$this->nodeRepo->updateCoinPriceOfNode($product, $request->get('price_coin'));
			$this->nodeRepo->updateFlashPriceOfNode($product, $request->get('flash_price'));
			$this->nodeRepo->updateDVDPriceOfNode($product, $request->get('dvd_price'));
		} catch (\Exception $e) {
			setDangerAlertSession();
		}


		/** @var string $uploadMediaPath */
		$uploadMediaPath = $product->productMediaPath();

		// icon image
		if ($request->file('icon')) {
			$res = $this->nodeMediaRepo->setNewIconImage($product, $request->file('icon'));
			if (!$res) {
				setDangerAlertSession('در بارگذاری فایل خطایی رخ داده است.');
				return redirect()->to(route('admin.product.index'));
			}
		}

		// background image
		if ($request->file('background')) {
			$res = $this->nodeMediaRepo->setNewBackgroundImage($product, $request->file('background'));
			if (!$res) {
				setDangerAlertSession('در بارگذاری فایل خطایی رخ داده است.');
				return redirect()->to(route('admin.product.index'));
			}
		}

		// Index
		if ($request->file('index')) {
			$res = $this->nodeMediaRepo->setNewIndexImage($product, $request->file('index'));
			if (!$res) {
				setDangerAlertSession('در بارگذاری فایل خطایی رخ داده است.');
				return redirect()->to(route('admin.product.index'));
			}
		}

		// File
		if ($file = $request->file('file')) {
			$res = $this->nodeMediaRepo->setNewProductFile($product, $request->file('file'));
			if (!$res) {
				setDangerAlertSession('در بارگذاری فایل خطایی رخ داده است.');
				return redirect()->to(route('admin.product.index'));
			}
		}
		setSuccessAlertSession();
		return redirect(route('admin.product.edit', ['product' => $product->id]));
	}


	/**
	 * @param \App\Http\Requests\Admin\ProductRequest $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
	 */
	public function fileUploader(\App\Http\Requests\Admin\ProductRequest $request)
	{
		$file = $request->file('file');
		/** @var string $fileType */
		$fileType = (new \App\Models\Media())->getTypeOfFile($file);

		$id = (int) $request->get('id');

		/** * @var \App\Models\Node $product */
		$product = $this->nodeRepo->find($id);

		/** @var int $size unit is KB */
		$size = $file->getSize();

		try {
			/** @var \Symfony\Component\HttpFoundation\File\File $res */
			if ($fileType === \App\Enums\MediaType::IMAGE) {
				$res = fileUploader(
					$file,
					$product->productMediaPath()
				);
				$fileName = $res->getFilename();
			} else {
				/** @var \Illuminate\Http\UploadedFile $res */
				$res = fileUploadToStorage(
					$file,
					$product->productMediaPath()
				);
				if ($res) {
					$fileName = $res;
				} else {
					session()->flash('alert', [
						'type' => 'danger',
						'message' => 'در بارگذاری فایل خطایی رخ داده است.',
					]);
					return redirect('admin.product.edit', ['id' => $id]);
				}
			}
		} catch (\Exception $th) {
			session()->flash('alert', [
				'type' => 'danger',
				'message' => 'در بارگذاری فایل خطایی رخ داده است.',
			]);
			return redirect('admin.product.edit', ['id' => $id]);
		}
		/** @var \App\Models\Media @media */
		$media = $this->mediaRepo->create([
			'size' => $size,
			'path' => $fileName
		]);
		if (is_null($order = $this->mediaRepo->getMaxOrderOfProductMedia($product))) {
			$order = 0;
		}
		$product->medias()->attach($media->id, [
			'type' => $fileType,
			'order' => $order + 1
		]);

		return response()->json();
	}

	/**
	 * @param string $id
	 * @param string $mediaId
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
	 */
	public function fileDownload($id, $mediaId)
	{
		try {
			/** @var \App\Models\Node $product */
			$product = $this->nodeRepo->find((int) $id);
			if (!$product) {
				session()->flash('alert', [
					'type' => 'danger',
					'message' => 'متاسفانه خطایی رخ داده است.'

				]);
				return redirect(route('admin.product.index'));
			}

			/** @var \App\Models\Media $media */
			$media = $product->medias->where('id', (int) $mediaId)->first();
			if ($media->pivot->type === \App\Enums\MediaType::IMAGE) {
				return response()->download(
					public_path(
						$product->productMediaPath()
							. $media->path
					)
				);
			} else {
				return \Storage::disk('public')->download(
					$product->productMediaPath() . $media->path
				);
			}
		} catch (\Exception $e) {
			session()->flash('alert', [
				'type' => 'danger',
				'message' => 'متاسفانه خطایی رخ داده است.'
			]);
			return redirect(route('admin.product.edit', ['id' => $id]));
		}
	}

	/**
	 *
	 * @param string $id
	 * @param string $mediaId
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function fileDelete($id, $mediaId): \Illuminate\Http\RedirectResponse
	{
		try {
			/** @var \App\Models\Node $product */
			$product = $this->nodeRepo->find((int) $id);
			if (!$product) {
				session()->flash('alert', [
					'type' => 'danger',
					'message' => 'متاسفانه خطایی رخ داده است.'

				]);
				return redirect(route('admin.product.index'));
			}

			/** @var \App\Models\Media $media */
			$media = $product->medias->where('id', (int) $mediaId)->first();

			// remove old picture
			if ($media->pivot->type === \App\Enums\MediaType::IMAGE) {
				removeMediaFromDirectory(
					$product->productMediaPath() . $media->path
				);
			} else {
				$res = \Storage::disk('public')->delete(
					$product->productMediaPath() . $media->path
				);
			}
			$product->medias()->detach((int) $mediaId);
			$this->mediaRepo->forceDelete($mediaId);

			session()->flash('alert', [
				'type' => 'success',
				'message' => 'با موفقیت انجام شد.'
			]);
		} catch (\Exception $e) {
			session()->flash('alert', [
				'type' => 'danger',
				'message' => 'متاسفانه خطایی رخ داده است.'
			]);
		}
		return redirect(route('admin.product.edit', ['id' => $id]));
	}

	/**
	 * @param string $id
	 * @param string $media_id
	 * @param \Illuminate\Http\Request $request
	 * @return \App\Http\Requests\Admin\ProductRequest
	 */
	public function changeFileOrder($id, $media_id, \App\Http\Requests\Admin\ProductRequest $request)
	{
		/** @var \App\Models\Node $product */
		$product = $this->nodeRepo->find((int) $id);
		if (!$product) {
			session()->flash('alert', [
				'type' => 'danger',
				'message' => 'متاسفانه خطایی رخ داده است.'

			]);
			return redirect(route('admin.product.index'));
		}

		$order = $product->medias()->where('medias.id', $media_id)->first()->pivot->order;
		$this->mediaRepo->changeOrderOfProductMedia($product, $order, $request->get('order'));

		session()->flash('alert', [
			'type' => 'success',
			'message' => 'با موفقیت انجام شد.'
		]);
		return redirect(route('admin.product.edit', ['id' => $id]));
	}

	/**
	 * @param integer product
	 * @return void
	 */
	public function destroy($product)
	{

		//TODO : Remove Files And Prices And All related things after 1month after soft delete
		$res = $this->nodeRepo->delete($product);
		if ($res) {
			session()->flash('alert', [
				'type' => 'success',
				'message' => 'با موفقیت انجام شد.'
			]);
		} else {
			session()->flash('alert', [
				'type' => 'danger',
				'message' => 'متاسفانه خطایی رخ داده است.'
			]);
		}
		return redirect(route('admin.product.index'));
	}
}
