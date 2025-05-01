<?php

namespace Database\Seeders;


use App\Models\User;
use App\Models\EntityUser;
use App\Models\EntityContact;
use App\Models\Entity;
use App\Models\UserPersonnel;
use App\Models\Personnel;
use App\Models\LeadType;
use App\Models\LeadPipelineStage;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\carbon;
use DB;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //App\Models\User::factory(10)->create();
        // $this->call(UserSeeder::class);

        $role_superadmin = Role::create(['name'=>'super-admin']);
        $role_admin = Role::create(['name'=>'admin']);
        $role_user = Role::create(['name'=>'user']);

        //Add a user namely admin
        $admin = User::factory()->create([
            'id'=>'1',
            'first_name' => 'user',
            'last_name' => 'Doe',
            'password' => Hash::make('password'),
            'email' => 'user@modocrm.com',
            'owner' => true,
        ]);
        $admin = User::factory()->create([
            'id'=>'2',
            'first_name' => 'admin',
            'last_name' => 'Doe',
            'password' => Hash::make('password'),
            'email' => 'admin@modocrm.com',
            'owner' => true,
        ]);
        $admin = User::factory()->create([
            'id'=>'3',
            'first_name' => 'Super Admin',
            'last_name' => 'Admin',
            'password' => Hash::make('password'),
            'email' => 'superadmin@modocrm.com',
            'owner' => false,
        ]);

        $entity = Entity::factory()->create([
            'entity_type' => '1',
            'legal_name' => 'ONE MODO',
            'parent_id' => '1',
            'alias' => 'modo',
            'description' => 'hey how this company data list',
            'gstin' => '1',
            'url' => '1',
            'logo_file'=>'',
            'time_zone'=>'1',
            'api_key'=>'1',
            'status'=>'1',
            'displayed'=>'0',
            'deleted'=>'0',
        ]);
        $entity = Entity::factory()->create([
            'entity_type' => '2',
            'legal_name' => 'Company MODO',
            'parent_id' => '1',
            'alias' => 'Company data',
            'description' => 'hey how this company data list',
            'gstin' => '1',
            'url' => '1',
            'logo_file'=>'',
            'time_zone'=>'1',
            'api_key'=>'1',
            'status'=>'1',
            'displayed'=>'0',
            'deleted'=>'0',
        ]);

        $entity = Entity::factory()->create([
            'entity_type' => '1',
            'legal_name' => 'SPRY type',
            'parent_id' => '',
            'alias' => 'sprt type',
            'description' => 'hey how this company data list',
            'gstin' => '1',
            'url' => '1',
            'logo_file'=>'',
            'time_zone'=>'1',
            'api_key'=>'1',
            'status'=>'1',
            'displayed'=>'0',
            'deleted'=>'0',
        ]);

        $entity = Entity::factory()->create([
            'entity_type' => '1',
            'legal_name' => 'PROTO SPRY',
            'parent_id' => '1',
            'alias' => 'PROTO ',
            'description' => 'hey how this company data list',
            'gstin' => '1',
            'url' => '1',
            'logo_file'=>'',
            'time_zone'=>'1',
            'api_key'=>'1',
            'status'=>'1',
            'displayed'=>'0',
            'deleted'=>'0',
        ]);

        $entityuser = EntityUser::factory()->create([
            'user_id' => '1',
            'entity_id' => '1',
            'entity_access' => '{"id":[1]}'
        ]);
        $entityuser = EntityUser::factory()->create([
            'user_id' => '2',
            'entity_id' => '1',
            'entity_access' => '{"id":[1]}'
        ]);
        $entityuser = EntityUser::factory()->create([
            'user_id' => '3',
            'entity_id' => '1',
            'entity_access' => '{"id":[1]}'
        ]);

        Personnel::factory()->times(1)->create();

        $userpersonnel = UserPersonnel::factory()->create([
            'user_id' => '1',
            'personnel_id' => '1',
        ]);
        $userpersonnel = UserPersonnel::factory()->create([
            'user_id' => '2',
            'personnel_id' => '1',
        ]);
        $userpersonnel = UserPersonnel::factory()->create([
            'user_id' => '3',
            'personnel_id' => '1',
        ]);
        $leadtype = LeadType::factory()->create([
            'lead_type' => 'test',
            'entity_id' => '1',
        ]);
        $leadstage = LeadPipelineStage::factory()->create([
            'code' => '1',
            'lead_stage' => 'First',
            'entity_id' => '1',
            'deleted'=>'0',
        ]);
        $leadstage = LeadPipelineStage::factory()->create([
            'code' => '2',
            'lead_stage' => 'Second',
            'entity_id' => '1',
            'deleted'=>'0',
        ]);
        $leadstage = LeadPipelineStage::factory()->create([
            'code' => '3',
            'lead_stage' => 'Third',
            'entity_id' => '1',
            'deleted'=>'0',
        ]);

        //Assign role admin to user admin
        $admin->assignRole($role_superadmin->name);

        //Create Permissions
        Permission::create(['name'=>'edit_users']);
        Permission::create(['name'=>'create_users']);
        Permission::create(['name'=>'delete_users']);
        Permission::create(['name'=>'edit_roles']);
        Permission::create(['name'=>'create_roles']);
        Permission::create(['name'=>'delete_roles']);
        Permission::create(['name'=>'edit_permissions']);
        Permission::create(['name'=>'create_permissions']);
        Permission::create(['name'=>'delete_permissions']);
        Permission::create(['name'=>'edit_entity']);
        Permission::create(['name'=>'create_entity']);
        Permission::create(['name'=>'delete_entity']);
        Permission::create(['name'=>'edit_leads']);
        Permission::create(['name'=>'create_leads']);
        Permission::create(['name'=>'delete_leads']);
        Permission::create(['name'=>'edit_settings']);
        Permission::create(['name'=>'create_settings']);
        Permission::create(['name'=>'delete_settings']);
        Permission::create(['name'=>'edit_personnels']);
        Permission::create(['name'=>'create_personnels']);
        Permission::create(['name'=>'delete_personnels']);
        Permission::create(['name'=>'edit_products']);
        Permission::create(['name'=>'create_products']);
        Permission::create(['name'=>'delete_products']);
        Permission::create(['name'=>'edit_patroncontact']);
        Permission::create(['name'=>'create_patroncontact']);
        Permission::create(['name'=>'delete_patroncontact']);
        Permission::create(['name'=>'edit_invoices']);
        Permission::create(['name'=>'create_invoices']);
        Permission::create(['name'=>'delete_invoices']);
        Permission::create(['name'=>'edit_accounts']);
        Permission::create(['name'=>'create_accounts']);
        Permission::create(['name'=>'delete_accounts']);
        //menu
        Permission::create(['name'=>'menu_dashboard']);
        Permission::create(['name'=>'menu_entity']);
        Permission::create(['name'=>'menu_user']);
        Permission::create(['name'=>'menu_setting']);
        Permission::create(['name'=>'menu_lead']);
        Permission::create(['name'=>'menu_personnel']);
        Permission::create(['name'=>'menu_invoice']);
        Permission::create(['name'=>'menu_patron']);
        Permission::create(['name'=>'menu_tax']);
        Permission::create(['name'=>'menu_product']);
        Permission::create(['name'=>'menu_account']);

        // Get all permission
        $permissions = Permission::pluck('id','id')->all();

        //Give all permission to super-admin
        $role_superadmin->syncPermissions($permissions);

        //Admin permission
        $role_admin->givePermissionTo('edit_users');
        $role_admin->givePermissionTo('create_users');
        $role_admin->givePermissionTo('delete_users');
        $role_admin->givePermissionTo('create_leads');
        $role_admin->givePermissionTo('edit_leads');
        $role_admin->givePermissionTo('create_settings');
        $role_admin->givePermissionTo('edit_settings');
        $role_admin->givePermissionTo('create_personnels');
        $role_admin->givePermissionTo('edit_personnels');
        $role_admin->givePermissionTo('edit_products');
        $role_admin->givePermissionTo('create_products');
        $role_admin->givePermissionTo('delete_products');
        $role_admin->givePermissionTo('edit_patroncontact');
        $role_admin->givePermissionTo('create_patroncontact');
        $role_admin->givePermissionTo('delete_patroncontact');
        $role_admin->givePermissionTo('create_invoices');
        $role_admin->givePermissionTo('edit_invoices');
        $role_admin->givePermissionTo('edit_accounts');
        $role_admin->givePermissionTo('create_accounts');
        $role_admin->givePermissionTo('delete_accounts');
        //menu
        $role_admin->givePermissionTo('menu_dashboard');
        $role_admin->givePermissionTo('menu_user');
        $role_admin->givePermissionTo('menu_setting');
        $role_admin->givePermissionTo('menu_lead');
        $role_admin->givePermissionTo('menu_personnel');
        $role_admin->givePermissionTo('menu_invoice');
        $role_admin->givePermissionTo('menu_patron');
        $role_admin->givePermissionTo('menu_tax');
        $role_admin->givePermissionTo('menu_product');
        $role_admin->givePermissionTo('menu_account');

        //user give spesific permission
        $role_user->givePermissionTo('create_leads');
        $role_user->givePermissionTo('create_invoices');
        //menu
        $role_admin->givePermissionTo('menu_lead');


        $contacts = DB::table('contacts')->insert([
            'entity_id'=>'4',
            'line_1'=>'one modo',
            'line_2'=>'little mount',
            'city'=>'chennai',
            'state_name'=>'tamil nadu',
            'zipcode'=>'607800',
            'landmark'=>'',
            'contact_type'=>'Office',
            'tag'=>'',
            'email'=>'onemodo@onemodo.com',
            'mobile'=>'9568754122',
            'alt_mobile'=>'9568754122',
            'land_line'=>'9568754122',
            'created'=>now(),
            'created_by'=>'3',
            'modified'=>now(),
            'modified_by'=>'3',
            'status'=>'0',
            'displayed'=>'0',
            'deleted'=>'0',
       ]);
        $entitycontact = EntityContact::factory()->create([
            'contact_id' => '1',
            'entity_id' => '1',
        ]);
        $entitycontact = EntityContact::factory()->create([
            'contact_id' => '1',
            'entity_id' => '2',
        ]);
        $entitycontact = EntityContact::factory()->create([
            'contact_id' => '1',
            'entity_id' => '3',
        ]);
        $entitycontact = EntityContact::factory()->create([
            'contact_id' => '1',
            'entity_id' => '4',
        ]);
        $entitycontact = EntityContact::factory()->create([
            'contact_id' => '1',
            'entity_id' => '4',
        ]);
        $email = DB::table('emails')->insert([
            'entity_id'=>'1',
            'type'=>'Monthly',
            'name'=>'<tr><td align="center" ><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;"><tr><td align="left" bgcolor="#ffffff" style="padding: 36px 24px 0; font-family: "Source Sans Pro", Helvetica, Arial, sans-serif; border-top: 3px solid #d4dadf;"><h1 style="margin: 0; font-size: 32px; font-weight: 700; letter-spacing: -1px; line-height: 48px;">Thank you for your order!</h1></td></tr><tr><td align="left" bgcolor="#ffffff" style="padding: 24px; font-family: "Source Sans Pro", Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;"><p style="margin: 0;">Here is a summary of your recent order. If you have any questions or concerns about your order, please <a href="modomines.com">contact us</a>.</p></td></tr></table></td></tr>',
            'subject'=>'Your receipt from Modomines ERP Software for Invoice',
            'notes'=>'<tr><td align="center"  style="padding: 24px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;"><tr style="color:white;" ><td align="center" bgcolor="#4889a7" style="padding: 12px 24px; font-family: "Source Sans Pro", Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; color: #666;"><p style="margin: 0;">You received this mail because we received a request for [type_of_action] for your account. If you didn t request [type_of_action] you can safely delete this email.</p></td></tr><tr><td align="center" bgcolor="#4889a7" style="padding: 12px 24px; font-family: "Source pans Pro", Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; color: #666;"><p style="margin: 0;">To stop receiving these emails, you can <a href="modomines.com" target="_blank">unsubscribe</a> at any time.</p><p style="margin: 0;">Paste 1234 S. Broadway St. City, State 12345</p></td></tr></table></td></tr>',
            'team_condition'=>'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
            'created' => now(),
            'created_by'=>'1',
        ]);
        $email = DB::table('emails')->insert([
            'entity_id'=>'2',
            'type'=>'Monthly',
            'name'=>'<tr><td align="center" ><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;"><tr><td align="left" bgcolor="#ffffff" style="padding: 36px 24px 0; font-family: "Source Sans Pro", Helvetica, Arial, sans-serif; border-top: 3px solid #d4dadf;"><h1 style="margin: 0; font-size: 32px; font-weight: 700; letter-spacing: -1px; line-height: 48px;">Thank you for your order!</h1></td></tr><tr><td align="left" bgcolor="#ffffff" style="padding: 24px; font-family: "Source Sans Pro", Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;"><p style="margin: 0;">Here is a summary of your recent order. If you have any questions or concerns about your order, please <a href="modomines.com">contact us</a>.</p></td></tr></table></td></tr>',
            'subject'=>'Your receipt from Modomines ERP Software for Invoice',
            'notes'=>'<tr><td align="center"  style="padding: 24px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;"><tr style="color:white;" ><td align="center" bgcolor="#4889a7" style="padding: 12px 24px; font-family: "Source Sans Pro", Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; color: #666;"><p style="margin: 0;">You received this mail because we received a request for [type_of_action] for your account. If you didn t request [type_of_action] you can safely delete this email.</p></td></tr><tr><td align="center" bgcolor="#4889a7" style="padding: 12px 24px; font-family: "Source pans Pro", Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; color: #666;"><p style="margin: 0;">To stop receiving these emails, you can <a href="modomines.com" target="_blank">unsubscribe</a> at any time.</p><p style="margin: 0;">Paste 1234 S. Broadway St. City, State 12345</p></td></tr></table></td></tr>',
            'team_condition'=>'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
            'created' => now(),
            'created_by'=>'1',
        ]);
        $email = DB::table('emails')->insert([
            'entity_id'=>'3',
            'type'=>'Monthly',
            'name'=>'<tr><td align="center" ><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;"><tr><td align="left" bgcolor="#ffffff" style="padding: 36px 24px 0; font-family: "Source Sans Pro", Helvetica, Arial, sans-serif; border-top: 3px solid #d4dadf;"><h1 style="margin: 0; font-size: 32px; font-weight: 700; letter-spacing: -1px; line-height: 48px;">Thank you for your order!</h1></td></tr><tr><td align="left" bgcolor="#ffffff" style="padding: 24px; font-family: "Source Sans Pro", Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;"><p style="margin: 0;">Here is a summary of your recent order. If you have any questions or concerns about your order, please <a href="modomines.com">contact us</a>.</p></td></tr></table></td></tr>',
            'subject'=>'Your receipt from Modomines ERP Software for Invoice',
            'notes'=>'<tr><td align="center"  style="padding: 24px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;"><tr style="color:white;"><td align="center" bgcolor="#4889a7" style="padding: 12px 24px; font-family: "Source Sans Pro", Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; color: #666;"><p style="margin: 0;">You received this mail because we received a request for [type_of_action] for your account. If you didn t request [type_of_action] you can safely delete this email.</p></td></tr><tr><td align="center" bgcolor="#4889a7" style="padding: 12px 24px; font-family: "Source pans Pro", Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; color: #666;"><p style="margin: 0;">To stop receiving these emails, you can <a href="modomines.com" target="_blank">unsubscribe</a> at any time.</p><p style="margin: 0;">Paste 1234 S. Broadway St. City, State 12345</p></td></tr></table></td></tr>',
            'team_condition'=>'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
            'created' => now(),
            'created_by'=>'1',
        ]);
        $email = DB::table('emails')->insert([
            'entity_id'=>'4',
            'type'=>'Monthly',
            'name'=>'<tr><td align="center" ><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;"><tr><td align="left" bgcolor="#ffffff" style="padding: 36px 24px 0; font-family: "Source Sans Pro", Helvetica, Arial, sans-serif; border-top: 3px solid #d4dadf;"><h1 style="margin: 0; font-size: 32px; font-weight: 700; letter-spacing: -1px; line-height: 48px;">Thank you for your order!</h1></td></tr><tr><td align="left" bgcolor="#ffffff" style="padding: 24px; font-family: "Source Sans Pro", Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;"><p style="margin: 0;">Here is a summary of your recent order. If you have any questions or concerns about your order, please <a href="modomines.com">contact us</a>.</p></td></tr></table></td></tr>',
            'subject'=>'Your receipt from Modomines ERP Software for Invoice',
            'notes'=>'<tr><td align="center"  style="padding: 24px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;"><tr style="color:white;"><td align="center" bgcolor="#4889a7" style="padding: 12px 24px; font-family: "Source Sans Pro", Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; color: #666;"><p style="margin: 0;">You received this mail because we received a request for [type_of_action] for your account. If you didn t request [type_of_action] you can safely delete this email.</p></td></tr><tr><td align="center" bgcolor="#4889a7" style="padding: 12px 24px; font-family: "Source pans Pro", Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; color: #666;"><p style="margin: 0;">To stop receiving these emails, you can <a href="modomines.com" target="_blank">unsubscribe</a> at any time.</p><p style="margin: 0;">Paste 1234 S. Broadway St. City, State 12345</p></td></tr></table></td></tr>',
            'team_condition'=>'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
            'created' => now(),
            'created_by'=>'1',
        ]);

        $this->call(TaxesTableSeeder::class);
        $this->call(EntitySeeder::class);
    }
}
