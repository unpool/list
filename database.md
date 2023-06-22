# koodak database

### medias
- id
- size
- path
- duration -> default 0
- created_at
- updated_at
- deleted_at

### mediables
- id
- mediable_id
- mediable_type
- media_id
- type
- created_at
- updated_at

### nodes
> files and images linked in medias table
- id
- title
- description
- left
- right
- depth
- parent_id
- create_at
- updated_at

### prices
- id
- node_id
- type
- amount
- created_at
- updated_at

### orders
- id
- user_id
- price
- discount_price
- discount_id
- is_paid
- created_at
- updated_at

### orderables
- id
- orderable_id
- orderable_type
- price
- order_id
- created_at
- updated_at

### payment_types
> type values: `cash`, `coin`
> We can store these values in enum class
- id
- price
- type
- order_id
- created_at
- updated_at

### transactions
> reason values: `spin`, `invite`, `gateway`, `pos`
> We can store these values in enum class
- id
- user_id
- reason
- amount
- reference_number
- created_at
- updated_at

### accounts_banks
- id 
- user_id
- first_name
- last_name
- account_number
- created_at
- updated_at

### users
- id
- first_name
- last_name
- email
- phone
- password
- birth_date
- invite_code
- fcm_token
- created_at
- updated_at

### user_IMIEs
- id
- user_id
- imie
- create_at
- updated_at

### admins
- id
- first_name
- last_name
- email
- password
- remember_token
- created_at
- updated_at

### teachers
- id
- first_name
- last_name
- email
- password
- remember_token
- created_at
- updated_at

### best_nodes
- id
- node_id
- created_at
- updated_at

### comments
> voice linked in medias table
- id
- user_id
- node_id
- comment
- created_at
- updated_at

### discounts
- id
- title
- code
- type
- value
- description `nullable`
- is_global
- start_at `nullable`
- end_at `nullable`
- created_at
- updated_at

### invites
> We can delete this table and save the `invite_id` to the `parent_id` column in user table. This table holds for the `created_at` column.
- id
- user_id
- invited_id
- created_at
- update_at

### enums
> this table added for dynamic enums. like present value and invited_user value
- id
- key
- value
- created_at
- updated_at

### conversations
- id
- text
- node_id
- conversationable_id
- conversationable_type
- reply_id `nullable`
- created_at
- updated_at

### sms_codes
> This table does not require an foreign key and `updated_at` column
- id
- mobile
- code
- created_at

### sliders
> images linked in medias table
- id
- title
- description
- link
- created_at
- updated_at


> Add spatie permission package
### roles **(Deleted)**
- id
- title
- description
- created_at
- updated_at

### user_roles **(Deleted)**
- id
- user_id
- role_id

### notifications
- id
- user_id
- title
- body
- created_at
- updated_at

### description_classes !!!
`??????????????????????????`

