<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Product Form</title>
</head>
<body>
    <h2>Upload Product</h2>
    <form action="upload_product.php" method="post" enctype="multipart/form-data">
        <label for="product_name">Product Name:</label><br>
        <input type="text" id="product_name" name="product_name" required><br><br>

        <label for="product_description">Product Description:</label><br>
        <textarea id="product_description" name="product_description" rows="4" required></textarea><br><br>

        <label for="product_price">Price:</label><br>
        <input type="number" id="product_price" name="product_price" step="0.01" required><br><br>

        <label for="product_image">Product Image:</label><br>
        <input type="file" id="product_image" name="product_image" accept="image/*" required><br><br>

        <input type="submit" name="submit" value="Upload Product">
    </form>
</body>
</html>
