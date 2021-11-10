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

