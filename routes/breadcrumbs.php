<?php
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
    // Dashboard
    Breadcrumbs::for('dashboard', function ($trail) {
        $trail->push('Dashboard', route('dashboard'));
    });

    // Categories
    Breadcrumbs::for('categories', function ($trail) {
        $trail->parent('dashboard');
        $trail->push('Categories Management', route('categories.index'));
    });
    Breadcrumbs::for('add_category', function ($trail) {
        $trail->parent('categories');
        $trail->push('Create Category', route('categories.create'));
    });
    Breadcrumbs::for('edit_category', function ($trail, $id) {
        $trail->parent('categories');
        $trail->push('Edit Category', route('categories.edit', $id));
    });

    // Products
    Breadcrumbs::for('products', function ($trail) {
        $trail->parent('dashboard');
        $trail->push('Products Management', route('products.index'));
    });
    Breadcrumbs::for('add_product', function ($trail) {
        $trail->parent('products');
        $trail->push('Create Product', route('products.create'));
    });
    Breadcrumbs::for('edit_product', function ($trail, $id) {
        $trail->parent('products');
        $trail->push('Edit Product', route('products.edit', $id));
    });

    // Detail Products 
    Breadcrumbs::for('products-detail', function ($trail) {
        $trail->parent('dashboard');
        $trail->push('Detail Products Management', route('detail-products.index'));
    });
    Breadcrumbs::for('add_product-detail', function ($trail, $id) {
        $trail->parent('products-detail');
        $trail->push('Create Detail Product ', route('detail-products.create', $id));
    });
    Breadcrumbs::for('edit_product-detail', function ($trail, $id) {
        $trail->parent('products-detail');
        $trail->push('Edit Detail Product', route('detail-products.edit', $id));
    });

    //Request Recharge 
    Breadcrumbs::for('recharge_request_management', function ($trail) {
        $trail->parent('dashboard');
        $trail->push('Recharge Request Management', route('recharges.index'));
    });

