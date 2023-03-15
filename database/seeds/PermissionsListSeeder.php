<?php

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected $permissionsList = [
        //Permissions clients
        ['name' => 'clients.index', 'description' => 'Listar Clientes', 'guard_name' => 'web'],
        ['name' => 'clients.create', 'description' => 'Crear Clientes', 'guard_name' => 'web'],
        ['name' => 'clients.edit', 'description' => 'Editar Clientes', 'guard_name' => 'web'],
        ['name' => 'clients.destroy', 'description' => 'Eliminar Clientes', 'guard_name' => 'web'],
        ['name' => 'clients.show', 'description' => 'Ver Clientes', 'guard_name' => 'web'],
        
        //Permissions sellers
        ['name' => 'sellers.index', 'description' => 'Listar Vendedores', 'guard_name' => 'web'],
        ['name' => 'sellers.create', 'description' => 'Crear Vendedores', 'guard_name' => 'web'],
        ['name' => 'sellers.edit', 'description' => 'Editar Vendedores', 'guard_name' => 'web'],
        ['name' => 'sellers.destroy', 'description' => 'Eliminar Vendedores', 'guard_name' => 'web'],
        ['name' => 'sellers.show', 'description' => 'Ver Vendedores', 'guard_name' => 'web'],

        //Permissions users
        ['name' => 'users.index', 'description' => 'Listar Usuarios', 'guard_name' => 'web'],
        ['name' => 'users.create', 'description' => 'Crear Usuarios', 'guard_name' => 'web'],
        ['name' => 'users.edit', 'description' => 'Editar Usuarios', 'guard_name' => 'web'],
        ['name' => 'users.destroy', 'description' => 'Eliminar Usuarios', 'guard_name' => 'web'],
        ['name' => 'users.show', 'description' => 'Ver Usuarios', 'guard_name' => 'web'],

        //Permissions negotiations
        ['name' => 'negotiations.index', 'description' => 'Listar Negociaciones', 'guard_name' => 'web'],
        ['name' => 'negotiations.create', 'description' => 'Crear Negociaciones', 'guard_name' => 'web'],
        ['name' => 'negotiations.edit', 'description' => 'Editar Negociaciones', 'guard_name' => 'web'],
        ['name' => 'negotiations.destroy', 'description' => 'Eliminar Negociaciones', 'guard_name' => 'web'],
        ['name' => 'negotiations.show', 'description' => 'Ver Negociaciones', 'guard_name' => 'web'],
        ['name' => 'negotiations.selection', 'description' => 'Enviar Negociación a Almacén(Selección)', 'guard_name' => 'web'],
        ['name' => 'negotiations.warehouse.packing', 'description' => 'Enviar Negociación a Almacén(Embalaje)', 'guard_name' => 'web'],
        ['name' => 'negotiations.warehouse.packed', 'description' => 'Recepción de Negociación de Almacén(Embalado)', 'guard_name' => 'web'],

        //Permissions products
        ['name' => 'products.index', 'description' => 'Listar Productos', 'guard_name' => 'web'],
        ['name' => 'products.create', 'description' => 'Crear Productos', 'guard_name' => 'web'],
        ['name' => 'products.edit', 'description' => 'Editar Productos', 'guard_name' => 'web'],
        ['name' => 'products.destroy', 'description' => 'Eliminar Productos', 'guard_name' => 'web'],
        ['name' => 'products.show', 'description' => 'Ver Productos', 'guard_name' => 'web'],
        ['name' => 'products.image', 'description' => 'Editar Imagenes de Productos', 'guard_name' => 'web'],
        ['name' => 'products.prices', 'description' => 'Editar Precios de Productos', 'guard_name' => 'web'],
        ['name' => 'products.massiveload', 'description' => 'Carga Masiva de Productos', 'guard_name' => 'web'],
        ['name' => 'products.massiveupdate', 'description' => 'Actualización Masiva de Productos', 'guard_name' => 'web'],

        //Permissions proformas
        ['name' => 'proformas.index', 'description' => 'Listar Proformas', 'guard_name' => 'web'],
        ['name' => 'proformas.create', 'description' => 'Crear Proformas', 'guard_name' => 'web'],
        ['name' => 'proformas.edit', 'description' => 'Editar Proformas', 'guard_name' => 'web'],
        ['name' => 'proformas.destroy', 'description' => 'Eliminar Proformas', 'guard_name' => 'web'],
        ['name' => 'proformas.show', 'description' => 'Ver Proformas', 'guard_name' => 'web'],
        ['name' => 'proformas.debug', 'description' => 'Depurar Proformas', 'guard_name' => 'web'],
        ['name' => 'proformas.invoiced', 'description' => 'Facturar Proformas', 'guard_name' => 'web'],
        ['name' => 'proformas.invoices.annul', 'description' => 'Anular Proformas Facturadas', 'guard_name' => 'web'],
        ['name' => 'proformas.create.provisional', 'description' => 'Crear Proformas Provisionales', 'guard_name' => 'web'],
        ['name' => 'proformas.provisional.convert.fiscal', 'description' => 'Convertir Proformas Provisionalesen Fiscales', 'guard_name' => 'web'],

        //Permissions purchases
        ['name' => 'purchases.index', 'description' => 'Listar Compras', 'guard_name' => 'web'],
        ['name' => 'purchases.create', 'description' => 'Crear Compras', 'guard_name' => 'web'],
        ['name' => 'purchases.edit', 'description' => 'Editar Compras', 'guard_name' => 'web'],
        ['name' => 'purchases.destroy', 'description' => 'Eliminar Compras', 'guard_name' => 'web'],
        ['name' => 'purchases.show', 'description' => 'Ver Compras', 'guard_name' => 'web'],
        ['name' => 'purchases.load', 'description' => 'Cargar Productos', 'guard_name' => 'web'],
        ['name' => 'purchases.load.edit', 'description' => 'Editar Carga de Compra', 'guard_name' => 'web'],
        ['name' => 'purchases.massiveload', 'description' => 'Carga Masiva de Productos', 'guard_name' => 'web'],
        ['name' => 'separatedproducts.create', 'description' => 'Control de Cantidades', 'guard_name' => 'web'],

        //Permissions banks
        ['name' => 'banks.index', 'description' => 'Listar Bancos', 'guard_name' => 'web'],
        ['name' => 'banks.create', 'description' => 'Crear Bancos', 'guard_name' => 'web'],
        ['name' => 'banks.edit', 'description' => 'Editar Bancos', 'guard_name' => 'web'],
        ['name' => 'banks.destroy', 'description' => 'Eliminar Bancos', 'guard_name' => 'web'],
        ['name' => 'banks.show', 'description' => 'Ver Bancos', 'guard_name' => 'web'],

        //Permissions payments
        ['name' => 'payments.index', 'description' => 'Listar Pagos', 'guard_name' => 'web'],
        ['name' => 'payments.process', 'description' => 'Procesar Pagos', 'guard_name' => 'web'],
        ['name' => 'payments.show.iva', 'description' => 'Ver Pagos', 'guard_name' => 'web'],
        ['name' => 'payments.show.invoice', 'description' => 'Ver Pagos', 'guard_name' => 'web'],
        
        //Permissions configurations
        ['name' => 'configurations.index', 'description' => 'Listar Configuraciones', 'guard_name' => 'web'],

        //Permissions transports
        ['name' => 'transports.index', 'description' => 'Listar Trasportes', 'guard_name' => 'web'],
        ['name' => 'transports.create', 'description' => 'Crear Trasportes', 'guard_name' => 'web'],
        ['name' => 'transports.edit', 'description' => 'Editar Trasportes', 'guard_name' => 'web'],
        ['name' => 'transports.destroy', 'description' => 'Eliminar Trasportes', 'guard_name' => 'web'],
        ['name' => 'transports.show', 'description' => 'Ver Trasportes', 'guard_name' => 'web'],

        //Permissions creditnotes
        ['name' => 'creditnotes.index', 'description' => 'Listar Notas de Credito', 'guard_name' => 'web'],
        ['name' => 'creditnotes.create', 'description' => 'Crear Notas de Credito', 'guard_name' => 'web'],
        ['name' => 'creditnotes.show', 'description' => 'Ver Notas de Credito', 'guard_name' => 'web'],
    ];
    public function run()
    {
        foreach ($this->permissionsList as $permission) {
            //$permission = Permission::create($permission);
            Permission::create($permission);
        }

        $role = Role::create(['name' => 'super.admin']);


    }
}
