<?php 
session_start();

if (!isset($_SESSION['admin'])) {
    // Redirect non-admins to dedicated admin login page
    header("Location: /Amazon_webSite/admin/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Product Management</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            box-sizing: border-box;
        }

        body {
            background-color: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        h1 {
            color: #131921;
            margin-bottom: 10px;
            border-bottom: 3px solid #FF9900;
            padding-bottom: 10px;
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .back-link {
            color: #0066c0;
            text-decoration: none;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        /* ================= ADD PRODUCT FORM ================= */
        .add-product-section {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            border: 1px solid #ddd;
        }

        .add-product-section h2 {
            color: #131921;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="file"]:focus {
            outline: none;
            border-color: #FF9900;
            box-shadow: 0 0 5px rgba(255, 153, 0, 0.3);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        button {
            background-color: #FF9900;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #e68a00;
        }

        /* ================= PRODUCTS TABLE ================= */
        .products-section h2 {
            color: #131921;
            margin-bottom: 15px;
            font-size: 18px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th {
            background-color: #131921;
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: bold;
        }

        td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .product-id {
            font-weight: bold;
            color: #0066c0;
        }

        .product-image {
            max-width: 80px;
            height: auto;
            border-radius: 4px;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn-edit {
            background-color: #0066c0;
            padding: 8px 15px;
            font-size: 12px;
        }

        .btn-edit:hover {
            background-color: #004ba0;
        }

        .btn-delete {
            background-color: #d32f2f;
            padding: 8px 15px;
            font-size: 12px;
        }

        .btn-delete:hover {
            background-color: #b71c1c;
        }

        /* ================= ALERTS ================= */
        .alert {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            display: none;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            display: block;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            display: block;
        }

        .no-products {
            text-align: center;
            color: #666;
            padding: 40px;
            font-size: 16px;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .modal-content h3 {
            color: #131921;
            margin-bottom: 20px;
        }

        .modal-buttons {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .btn-cancel {
            background-color: #666;
            padding: 10px 20px;
        }

        .btn-cancel:hover {
            background-color: #555;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            table {
                font-size: 12px;
            }

            td, th {
                padding: 8px 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="admin-header">
            <h1>📦 Product Management Dashboard</h1>
            <div style="display: flex; gap: 15px;">
                <a href="../FrontEnd/index.php" class="back-link">
                    <i class="material-icons">arrow_back</i>
                    Back to Home
                </a>
                <a href="../BackEnd/logout.php" class="back-link" style="color: #d32f2f;" onclick="event.preventDefault(); fetch('/Amazon_webSite/BackEnd/logout.php', {credentials:'same-origin'}).then(()=>{ window.location='/Amazon_webSite/FrontEnd/auth.php'; }).catch(()=>{ window.location='/Amazon_webSite/FrontEnd/auth.php'; });">
                    <i class="material-icons">exit_to_app</i>
                    Logout
                </a>
            </div>
        </div>

        <!-- Alert Messages -->
        <div id="alertMessage" class="alert"></div>

        <!-- Add Product Form -->
        <div class="add-product-section">
            <h2>➕ Add New Product</h2>
            <form id="addProductForm" method="POST" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group">
                        <label for="productName">Product Name *</label>
                        <input type="text" id="productName" name="productName" required placeholder="Enter product name">
                    </div>
                    <div class="form-group">
                        <label for="productPrice">Price (₹) *</label>
                        <input type="number" id="productPrice" name="productPrice" required placeholder="Enter price" min="0" step="0.01">
                    </div>
                </div>
                <div class="form-group">
                    <label for="productImage">Upload Image *</label>
                    <input type="file" id="productImage" name="productImage" accept="image/*" required>
                    <small style="color:#666;">(Allowed: jpg, jpeg, png, gif) — file will be saved to FrontEnd/images/</small>
                </div>
                <button type="submit" class="btn-add">➕ Add Product</button>
            </form>
        </div>

        <!-- Products Table -->
        <div class="products-section">
            <h2>📋 All Products</h2>
            <div id="productsTable"></div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <h3>✏️ Edit Product</h3>
            <form id="editProductForm">
                <input type="hidden" id="editProductId">
                <div class="form-group">
                    <label for="editProductName">Product Name *</label>
                    <input type="text" id="editProductName" required>
                </div>
                <div class="form-group">
                    <label for="editProductPrice">Price (₹) *</label>
                    <input type="number" id="editProductPrice" required min="0" step="0.01">
                </div>
                <div class="form-group">
                    <label for="editProductImage">Image File Name *</label>
                    <input type="text" id="editProductImage" required>
                </div>
                <div class="modal-buttons">
                    <button type="button" class="btn-cancel" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="btn-edit">💾 Update Product</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Load products on page load
        document.addEventListener('DOMContentLoaded', () => {
            loadProducts();
            
            // Add product form handler
            document.getElementById('addProductForm').addEventListener('submit', (e) => {
                e.preventDefault();
                addProduct();
            });

            // Edit product form handler
            document.getElementById('editProductForm').addEventListener('submit', (e) => {
                e.preventDefault();
                updateProduct();
            });
        });

        // Load and display all products
        function loadProducts() {
            fetch('actions.php?action=get_all', {
                method: 'GET'
            })
            .then(response => response.json())
            .then(data => {
                displayProducts(data.products || []);
            })
            .catch(error => console.error('Error:', error));
        }

        // Display products in table
        function displayProducts(products) {
            const tableDiv = document.getElementById('productsTable');
            
            if (products.length === 0) {
                tableDiv.innerHTML = '<p class="no-products">No products found. Add one to get started!</p>';
                return;
            }

            let html = `
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            products.forEach(product => {
                html += `
                    <tr>
                        <td class="product-id">#${product.id}</td>
                        <td>${product.name}</td>
                        <td>₹${product.price}</td>
                        <td><img src="../FrontEnd/images/${product.image}" class="product-image" alt="${product.name}"></td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-edit" onclick="openEditModal(${product.id}, '${product.name}', '${product.price}', '${product.image}')">✏️ Edit</button>
                                <button class="btn-delete" onclick="deleteProductConfirm(${product.id}, '${product.name}')">🗑️ Delete</button>
                            </div>
                        </td>
                    </tr>
                `;
            });

            html += `
                    </tbody>
                </table>
            `;

            tableDiv.innerHTML = html;
        }

        // Add new product
        function addProduct() {
                const name = document.getElementById('productName').value;
                const price = document.getElementById('productPrice').value;
                const imageInput = document.getElementById('productImage');
                const imageFile = imageInput && imageInput.files && imageInput.files[0] ? imageInput.files[0] : null;

                if (!name || !price || !imageFile) {
                    showAlert('Please fill in all fields and select an image', 'error');
                    return;
                }

                const formData = new FormData();
                formData.append('action', 'add');
                formData.append('name', name);
                formData.append('price', price);
                formData.append('productImage', imageFile);

                fetch('actions.php', {
                    method: 'POST',
                    body: formData
                })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('✓ ' + data.message, 'success');
                    document.getElementById('addProductForm').reset();
                    loadProducts();
                } else {
                    showAlert('✗ ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Error adding product', 'error');
            });
        }

        // Open edit modal
        function openEditModal(id, name, price, image) {
            document.getElementById('editProductId').value = id;
            document.getElementById('editProductName').value = name;
            document.getElementById('editProductPrice').value = price;
            document.getElementById('editProductImage').value = image;
            document.getElementById('editModal').classList.add('show');
        }

        // Close edit modal
        function closeEditModal() {
            document.getElementById('editModal').classList.remove('show');
        }

        // Update product
        function updateProduct() {
            const id = document.getElementById('editProductId').value;
            const name = document.getElementById('editProductName').value;
            const price = document.getElementById('editProductPrice').value;
            const image = document.getElementById('editProductImage').value;

            const formData = new FormData();
            formData.append('action', 'update');
            formData.append('id', id);
            formData.append('name', name);
            formData.append('price', price);
            formData.append('image', image);

            fetch('actions.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('✓ ' + data.message, 'success');
                    closeEditModal();
                    loadProducts();
                } else {
                    showAlert('✗ ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Error updating product', 'error');
            });
        }

        // Delete product with confirmation
        function deleteProductConfirm(id, name) {
            if (confirm(`Are you sure you want to delete "${name}"? This action cannot be undone.`)) {
                deleteProduct(id);
            }
        }

        // Delete product
        function deleteProduct(id) {
            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('id', id);

            fetch('actions.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('✓ ' + data.message, 'success');
                    loadProducts();
                } else {
                    showAlert('✗ ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Error deleting product', 'error');
            });
        }

        // Show alerts
        function showAlert(message, type) {
            const alertDiv = document.getElementById('alertMessage');
            alertDiv.textContent = message;
            alertDiv.className = `alert alert-${type}`;
            
            setTimeout(() => {
                alertDiv.className = 'alert';
            }, 4000);
        }

        // Close modal when clicking outside
        document.getElementById('editModal').addEventListener('click', (e) => {
            if (e.target === document.getElementById('editModal')) {
                closeEditModal();
            }
        });
    </script>
</body>
</html>
