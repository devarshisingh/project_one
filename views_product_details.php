<?php
session_start();
include("assets/e-commerce_includefile/header.php");
include("config/dbcons.php");
?>
<style>
       .filter-titles {
        font-size: 1.8rem;
        font-weight: bold;
        color: #333;
        text-transform: uppercase;
        letter-spacing: 1px;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
    }
</styl<style>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">.link1 a {
        color: aliceblue;
        text-decoration: none;
    }

    .p2 a {
        text-decoration: none;
        text-align: center;
    }

    .card-img-top {
        transition: transform 0.3s ease;
    }

    .card-img-top:hover {
        transform: scale(1.1);
    }

    .card-body button {
        margin: 0px 10px;
    }
    .a11 button {
        margin: 0px 9px;
    }
    .fixed-heights {
        height: 24px;
        overflow: hidden;
    }

    .fixed-height-cards {
        height: 358px;
        overflow: hidden;
    }

    .name {
        font-family: Georgia, serif;
        margin-top: -20px;
    }

    .price-space {
        margin-left: 10px;
    }

    .price-space del {
        color: red;
        font-weight: bold;
    }

    .price {
        font-weight: bold;
    }

    .offer {
        color: darkcyan;
    }

    .color {
        color: darkcyan;
    }

    .card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .card p {
        margin-bottom: 1px;
        font-size: 14px;
    }

    .card-body {
        position: relative;
        transition: transform 0.3s ease;
        background-color: white;
    }

    .card-body:hover {
        transform: translateY(-30px);
    }

    .card-text {
        transition: opacity 0.3s ease;
    }

    .card-body:hover .card-text {
        opacity: 1;
    }

    .card-text {
        opacity: 0.8;
        text-align: center;
        position: relative;
    }

    .filter-sidebar {
        background-color: #f8f9fa;
         border-left: 2px solid #dee2e6;
        border-right: 2px solid #dee2e6;
        border-bottom: 2px solid #dee2e6;
        border-radius: 0;
        padding: 20px;
    }


    .product-displays {
        background-color: ;
        padding: 10px;
        min-height: 100vh;
        border-left: 2px solid #dee2e6;
        border-right: 2px solid #dee2e6;
        border-bottom: 2px solid #dee2e6;
    }

    .filter-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
        text-transform: uppercase;
        letter-spacing: 1px;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
    }

    .filter-titles {
        font-size: 1.8rem;
        font-weight: bold;
        color: #333;
        text-transform: uppercase;
        letter-spacing: 1px;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
    }
    .fixed-width-col {
    width: 200px; /* Set your desired fixed width */
}
</style>
<h2 class="text-center filter-titles mb-4">CHOOSE PRODUCT</h2>
<?php
if (isset($_GET['product_ids']) && isset($_GET['category_id'])) {
    $pro_ids = $_GET['product_ids'];
    $category_id = $_GET['category_id'];

    // Prevent SQL injection by using prepared statements
    $query = "SELECT * FROM p_details WHERE p_name = ?";
    $stmt = mysqli_prepare($con, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $pro_ids);
        mysqli_stmt_execute($stmt);
        $query_run = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($query_run) > 0) {
            echo '<div class="row">'; // Start row for product cards
            while ($row = mysqli_fetch_assoc($query_run)) {
                ?>
                <div class="col-md-3 mb-4">
                    <div class="card fixed-height-cards">
                        <a href="views_all_details_of_product.php?product_id=<?php echo htmlspecialchars($row['id']); ?>">
                            <img src="<?php echo htmlspecialchars($row['pd_image']); ?>"
                                 alt="<?php echo htmlspecialchars($row['p_name']); ?>" class="card-img-top"
                                 style="height: 200px; object-fit: cover;">
                        </a>
                        <div class="card-body">
                            <h5 class="card-text name fixed-heights"><?php echo htmlspecialchars($row['pdname']); ?></h5>
                            <p class="card-text color"><?php echo htmlspecialchars($row['p_color']); ?></p>
                            <p class="card-text price">₹<?php echo htmlspecialchars($row['p_price']); ?>
                                <span class="price-space"><del>₹<?php echo htmlspecialchars($row['p_off_price']); ?></del></span>
                                <span class="price-space"><?php echo htmlspecialchars($row['p_p_discount']); ?> off</span>
                            </p>
                            <p class="card-text"><?php echo htmlspecialchars($row['p_size']); ?></p>
                            <p class="card-text"><?php echo htmlspecialchars($row['p_delivery']); ?></p>
                            <div class="d-flex  justify-content-between">
                                <button class="btn btn-primary btn-sm"
                                        onclick="addToCart('<?php echo htmlspecialchars($row['id']); ?>')">Add to Cart</button>
                                <button class="btn btn-success btn-sm"
                                        onclick="buyNow('<?php echo htmlspecialchars($row['id']); ?>')">Buy Now</button>
                            </div>
                            <p class="card-text offer"><?php echo htmlspecialchars($row['p_deal']); ?></p>
                        </div>
                    </div>
                </div>
                <?php
            }
            echo '</div>'; // Closing row
        } else {
            echo '<div class="alert alert-warning">No Records Found</div>';
        }
    } else {
        echo '<div class="alert alert-danger">Database error: ' . htmlspecialchars(mysqli_error($con)) . '</div>';
    }
} else {
    echo '<div class="alert alert-warning">Invalid Request</div>';
}

include("views_css_products.php");
?>



</body>
</html>
