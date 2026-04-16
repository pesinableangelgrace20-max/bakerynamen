<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f4f7fa; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        h2 { text-align: center; color: #2c3e50; margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: 600; color: #666; }
        input { width: 100%; padding: 12px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        .btn-update { width: 100%; padding: 12px; background: #27ae60; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 16px; }
        .btn-cancel { display: block; text-align: center; margin-top: 15px; color: #7f8c8d; text-decoration: none; font-size: 14px; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Edit Product</h2>
        <form action="<?= base_url('admin/product/update/'.$product['id']) ?>" method="post">
            <?= csrf_field() ?>
            <label>Product Name</label>
            <input type="text" name="name" value="<?= esc($product['name']) ?>" required>
            
            <label>Price</label>
            <input type="number" step="0.01" name="price" value="<?= esc($product['price']) ?>" required>
            
            <label>Stock</label>
            <input type="number" name="stock" value="<?= esc($product['stock']) ?>" required>
            
            <button type="submit" class="btn-update">Update Product</button>
            <a href="<?= base_url('admin') ?>" class="btn-cancel">Cancel</a>
        </form>
    </div>
</body>
</html>

