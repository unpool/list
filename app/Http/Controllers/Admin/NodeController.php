<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Node;
use Illuminate\Http\{JsonResponse, RedirectResponse, Request};
use Illuminate\View\View;
use App\Repositories\{NodeRepositoryImp, MediaRepositoryImp, NodeMediaRepositoryImp};

class NodeController extends Controller
{
	/** * @var NodeRepositoryImp */
	private $nodeRepo;

	/** @var MediaRepositoryImp $mediaRepo */
	private $mediaRepo;

	/** @var NodeMediaRepositoryImp $nodeMediaRepo */
	private $nodeMediaRepo;

	public function __construct(NodeRepositoryImp $node_repo, MediaRepositoryImp $mediaRepo, NodeMediaRepositoryImp $nodeMediaRepo)
	{
		$this->nodeRepo = $node_repo;
		$this->mediaRepo = $mediaRepo;
		$this->nodeMediaRepo = $nodeMediaRepo;
	}

	/**
	 * Display a listing of the resource.
	 * @return View
	 */
	public function index(): View
	{
		$html_view = '<ul>';
		foreach ($this->nodeRepo->getRoots() as $node) {
			$html_view .= $this->parseChildForHtml($node);
		}
		$html_view .= '</ul>';

		return view('admin.node.index', [
			'nodes_count' => $this->nodeRepo->count(),
			'html_nodes' => $html_view,
			'roots' => $this->nodeRepo->getRoots(),
		]);
	}

	public function parseChildForHtml(Node $node)
	{
		if ($node->is_product) {
			$html = "<li data-jstree='{\"icon\":\"fa fa-cube\"}' id='$node->id'>";
		} else {
			$html = "<li data-jstree='{\"icon\":\"fa fa-list\"}'  id='$node->id'>";
		}
		$html .= $node->id . ' - ' . $node->title;
		if ($node->children->count()) {
			$html .= '<ul>';
			foreach ($node->children()->get() as $child_node) {
				if ($child_node->children()->count()) {
					$html .= $this->parseChildForHtml($child_node);
				} else {
					if ($child_node->is_product == 1) {
						$html .= "<li class=\"no_checkbox\"  data-jstree='{\"disabled\":true,\"checked\":false,\"icon\":\"fa fa-cube\"}' id='$child_node->id'>";
					} else {
						$html .= "<li data-jstree='{\"icon\":\"fa fa-list\"}' id='$child_node->id'>";
					}
					$html .= $child_node->id . ' - ' . $child_node->title;
				}
				$html .= '</li>';
			}
			$html .= '</ul>';
		}
		$html .= '</li>';
		return $html;
	}

	public function create()
	{
		return view('admin.node.create', [
			'root_nodes' => $this->nodeRepo->getRoots()
		]);
	}

	/**
	 * @todo validation
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(\App\Http\Requests\Admin\Node $request)
	{
		if ($request->get('category')) {
			/** @var \App\Models\Node $parent */
			$parent = $this->nodeRepo->findOneOrFail($request->get('category'));
		} else {
			/** @var null $parent */
			$parent = null;
		}

		/** @var \App\Models\Node $node */
		$node = $this->nodeRepo->addChildNode(
			[
				'title' => $request->get('title'),
				'score' => $request->get('score'),
				'description' => $request->get('description')
			],
			$parent
		);

		$this->nodeRepo->updateCashPriceOfNode($node, (float) $request->get('price', 0));
		$this->nodeRepo->updateCoinPriceOfNode($node, (float) $request->get('price_coin', 0));
		$this->nodeRepo->updateFlashPriceOfNode($node, (float) $request->get('flash_price', 0));
		$this->nodeRepo->updateDVDPriceOfNode($node, (float) $request->get('dvd_price', 0));

		// index image
		if ($request->file('image')) {
			$res = $this->nodeMediaRepo->setNewIndexImage($node, $request->file('image'));
			if (!$res) {
				setDangerAlertSession('در بارگذاری فایل خطایی رخ داده است.');
				return redirect()->to(route('admin.product.index'));
			}
		}

		// icon image
		if ($request->file('icon')) {
			$res = $this->nodeMediaRepo->setNewIconImage($node, $request->file('icon'));
			if (!$res) {
				setDangerAlertSession('در بارگذاری فایل خطایی رخ داده است.');
				return redirect()->to(route('admin.product.index'));
			}
		}

		// background image
		if ($request->file('background')) {
			$res = $this->nodeMediaRepo->setNewBackgroundImage($node, $request->file('background'));
			if (!$res) {
				setDangerAlertSession('در بارگذاری فایل خطایی رخ داده است.');
				return redirect()->to(route('admin.product.index'));
			}
		}

		setSuccessAlertSession();
		return redirect(route('admin.node.index'));
	}

	public function edit($id)
	{
		/** @var \App\Models\Node $node */
		$node = $this->nodeRepo->findOneOrFail($id);

		if ($indexMedia = $this->nodeRepo->getNodeIndexMedia($node)) {
			$media['index'] = $node->nodeMediaPath() . $indexMedia->path;
		}
		if ($iconMedia = $this->nodeRepo->getNodeIconMedia($node)) {
			$media['icon'] = $node->nodeMediaPath() . $iconMedia->path;
		}
		if ($backgroundMedia = $this->nodeRepo->getNodeBackgroundMedia($node)) {
			$media['background'] = $node->nodeMediaPath() . $backgroundMedia->path;
		}

		/** @var array $prices */
		$prices = [];
		foreach ($node->prices as $price) {
			$prices[$price->type] = $price->amount;
		}


		return view('admin.node.edit', [
			'prices' => $prices,
			'node_breadcrumbs' => $node->getAncestorsAndSelf()->pluck('title')->toArray(),
			'node' => $node,
			'media' => $media ?? []
		]);
	}

	public function update(\App\Http\Requests\Admin\Node $request, $id)
	{
		/** @var \App\Models\Node $node */
		$node = $this->nodeRepo->findOneOrFail($id);

		$node->update([
			'title' => $request->get('title'),
			'score' => $request->get('score', 0),
			'description' => $request->get('description')
		]);

		// $node->prices()->updateOrCreate([
		// 	'type' => \App\Enums\PriceType::CASH
		// ], [
		// 	'amount' => (float) $request->get('price', 0),
		// 	'off_percent' => $request->get('off_percent', 0),
		// ]);
		$this->nodeRepo->updateCashPriceOfNode($node, (float) $request->get('price', 0));
		$this->nodeRepo->updateCoinPriceOfNode($node, (float) $request->get('price_coin', 0));
		$this->nodeRepo->updateFlashPriceOfNode($node, (float) $request->get('flash_price', 0));
		$this->nodeRepo->updateDVDPriceOfNode($node, (float) $request->get('dvd_price', 0));


		// index image
		if ($request->file('image')) {
			$res = $this->nodeMediaRepo->setNewIndexImage($node, $request->file('image'));
			if (!$res) {
				setDangerAlertSession('در بارگذاری فایل خطایی رخ داده است.');
				return redirect()->to(route('admin.product.index'));
			}
		}

		// icon image
		if ($request->file('icon')) {
			$res = $this->nodeMediaRepo->setNewIconImage($node, $request->file('icon'));
			if (!$res) {
				setDangerAlertSession('در بارگذاری فایل خطایی رخ داده است.');
				return redirect()->to(route('admin.product.index'));
			}
		}

		// background image
		if ($request->file('background')) {
			$res = $this->nodeMediaRepo->setNewBackgroundImage($node, $request->file('background'));
			if (!$res) {
				setDangerAlertSession('در بارگذاری فایل خطایی رخ داده است.');
				return redirect()->to(route('admin.product.index'));
			}
		}

		setSuccessAlertSession();
		return redirect()->to(route('admin.node.index'));
	}

	/**
	 * @todo validation
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function move(Request $request): JsonResponse
	{
		/** @var \App\Models\Node $mustBeChangeOrder */
		$mustBeChangeOrder = $this->nodeRepo->findOneOrFail((int) $request->get('node_id'));
		if ($request->get('previos_node_id')) {
			/** @var \App\Models\Node $previos_node */
			$previos_node = $this->nodeRepo->findOneOrFail($request->get('previos_node_id'));
			$mustBeChangeOrder->moveToRightOf($previos_node);
		} else {
			if ((int) $request->get('new_parent_id')) {
				$parent = $this->nodeRepo->findOneOrFail((int) $request->get('new_parent_id'));
				$mustBeChangeOrder->makeFirstChildOf($parent);
			} else {
				/** 
				 * Get First Root Node
				 * @var \App\Models\Node $first_root 
				 */
				$first_root = $this->nodeRepo->getRoots()->first();
				/** Make $mustBeChangeOrder node To Root */
				$mustBeChangeOrder->makeRoot();
				$mustBeChangeOrder->moveToLeftOf($first_root);
			}
		}

		return response()->json([
			'status' => true,
			'messages' => ['عملیات با موفقیت انجام شد.'],
			'data' => null,
		]);
	}

	// /**
	//  * @todo validation
	//  * @param Request $request
	//  * @return JsonResponse
	//  */
	// public function rename(Request $request): JsonResponse
	// {
	// 	$this->nodeRepo->update([
	// 		'title' => $request->get('new_name'),
	// 	], (int) $request->get('node_id'));
	// 	return response()->json([
	// 		'status' => true,
	// 		'messages' => ['عملیات با موفقیت انجام شد.'],
	// 		'data' => null,
	// 	]);
	// }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy($id)
	{
		$this->nodeRepo->delete($id);
		setSuccessAlertSession();
		return redirect(route('admin.node.index'));
	}

	// public function options(Node $node): View
	// {
	// 	if ($indexMedia = $thils->nodeRepo->getNodeIndexMedia($node)) {
	// 		$media['index'] = $node->nodeMediaPath() . $indexMedia->path;
	// 	}
	// 	if ($iconMedia = $this->nodeRepo->getNodeIconMedia($node)) {
	// 		$media['icon'] = $node->nodeMediaPath() . $iconMedia->path;
	// 	}
	// 	if ($backgroundMedia = $this->nodeRepo->getNodeBackgroundMedia($node)) {
	// 		$media['background'] = $node->nodeMediaPath() . $backgroundMedia->path;
	// 	}

	// 	/** @var array $prices */
	// 	$prices = [];
	// 	foreach ($node->prices as $price) {
	// 		$prices[$price->type] = $price->amount;
	// 	}


	// 	return view('admin.node.options', [
	// 		'prices' => $prices,
	// 		'node_breadcrumbs' => $node->getAncestorsAndSelf()->pluck('title')->toArray(),
	// 		'node' => $node,
	// 		'media' => $media ?? []
	// 	]);
	// }

	// public function optionsSave(\App\Http\Requests\Admin\Node $request, Node $node): RedirectResponse
	// {
	// 	$node->update([
	// 		'score' => $request->get('score', 0)
	// 	]);

	// 	$node->prices()->updateOrCreate([
	// 		'type' => \App\Enums\PriceType::CASH
	// 	], [
	// 		'amount' => (float) $request->get('price', 0),
	// 		'off_percent' => $request->get('off_percent', 0),
	// 	]);
	// 	$this->nodeRepo->updateCoinPriceOfNode($node, (float) $request->get('price_coin', 0));
	// 	$this->nodeRepo->updateFlashPriceOfNode($node, (float) $request->get('flash_price', 0));
	// 	$this->nodeRepo->updateDVDPriceOfNode($node, (float) $request->get('dvd_price', 0));


	// 	// index image
	// 	if ($request->file('image')) {
	// 		$res = $this->nodeMediaRepo->setNewIndexImage($node, $request->file('image'));
	// 		if (!$res) {
	// 			setDangerAlertSession('در بارگذاری فایل خطایی رخ داده است.');
	// 			return redirect()->to(route('admin.product.index'));
	// 		}
	// 	}

	// 	// icon image
	// 	if ($request->file('icon')) {
	// 		$res = $this->nodeMediaRepo->setNewIconImage($node, $request->file('icon'));
	// 		if (!$res) {
	// 			setDangerAlertSession('در بارگذاری فایل خطایی رخ داده است.');
	// 			return redirect()->to(route('admin.product.index'));
	// 		}
	// 	}

	// 	// background image
	// 	if ($request->file('background')) {
	// 		$res = $this->nodeMediaRepo->setNewBackgroundImage($node, $request->file('background'));
	// 		if (!$res) {
	// 			setDangerAlertSession('در بارگذاری فایل خطایی رخ داده است.');
	// 			return redirect()->to(route('admin.product.index'));
	// 		}
	// 	}

	// 	setSuccessAlertSession();
	// 	return redirect()->to(route('admin.node.index'));
	// }
}
