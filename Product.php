<?php
$host = 'localhost';
$dbname = 'ohanna';
$user = 'root';

$dsn = "mysql:host=$host;dbname=$dbname";
$db = new PDO($dsn, $user);

$user = $_SESSION['user'];
$hid = isset($_GET['hid']) ? intval($_GET['hid']) : 1;

$pname =isset($_REQUEST['pname']);
$price =isset($_REQUEST['price']);
$label = isset($_REQUEST['label']);
$lntroduction = isset($_REQUEST['Introduction']);

$sql = "SELECT * FROM product WHERE hid = :hid";
$stmt = $db->prepare($sql);
$stmt->bindParam(':hid', $hid, PDO::PARAM_INT);
$stmt->execute();
$rows = $stmt->fetchAll();

if ($rows) {
    $row = $rows[0];
    $pname = $row['pname'];
    $price = $row['price'];
    $label = $row['label'];
    $lntroduction = $row['Introduction'];
} else {
    echo "找不到商品";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>O,HANNAH</title>
    <link rel="icon" href="./img/OHA_icon.jpg">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./css/Accordion.css">
    <link rel="stylesheet" href="./css/member.css">

</head>
<style>
    #H {
        border-radius: 50%;
    }

    /* 服務條款 */
    #tyModal {
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            margin-top:50px ;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .tyModalContent {
            background-color: whitesmoke;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .tyClose {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .tyClose:hover,
        .tyClose:focus {
            color: #ff0000;
            cursor: pointer;
        }

        .cart-item { 
            border-bottom: 1px solid #ddd;
            padding: 5px; 
            font-size: 20px;
        }
        
    /* 購物車 */
    .decrease, .increase, .remove{
        color: white;
        background-color: black;
        border: none;
        border-radius: 20%;
    }
    .decrease, .increase{
        border-radius: 50%;
        font-size: 20px;
    }
    #sp{
        width: 100%;
        color: white;
        background-color: black;
        border: none;
        border-radius: 3px;
        padding: 10px;
        margin-top: 10% ;
    }
    #sp:hover{
        opacity: 0.8;
    }

    /* 商品圖切換 */
    .con {
            display: flex;
            gap: 20px;
        }
        .thumbnails {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .thumbnails img {
            width: 60px;
            height: 60px;
            cursor: pointer;
            border-radius: 8px;
            border: 2px solid transparent;
        }
        .thumbnails img.active {
            border-color: #e74c3c;
        }
        #mainImage{
            border-radius: 8px;
        }
        
</style>


<header class="mb-5">
    <nav class="navbar navbar-expand-md fixed-top bg-light">
        <div class="container-fluid">
            <a class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#mySidebar"
                aria-controls="mySidebar" aria-expanded="false" aria-label="Toggle navigation" style="border: none;">
                <span class="navbar-toggler-icon"></span>
            </a>
            <div>
                <a class="navbar-brand" type="button" href="#">
                    <img src="./img/hader_icon.jpg" alt="Logo" style="width: 80px;">
                </a>
            </div>
            <div class="offcanvas-md offcanvas-start" id="mySidebar">
                <div class="offcanvas-header">
                    <a type="button" href="#">
                        <img src="./img/OHA_icon.jpg" alt="Logo" style="width: 80px;">
                    </a>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#mySidebar"
                        aria-label="Close"></button>
                </div>
                <ul class="navbar-nav offcanvas-body me-auto">
                    <li class="nav-item"><a class="nav-link" href="Clogin.html">所有產品</a></li>
                    <li class="nav-item"><a class="nav-link" href="#bestsellertop">暢銷TOP</a></li>
                    <li class="nav-item"><a class="nav-link" href="#footer">聯絡我們</a></li>
                </ul>
            </div>
            <form class="d-flex ms-auto" role="search">
                <input class="form-control" type="search" style="width: 150px;">
                <button class="btn btn-secondary " type="submit"><i class="bi bi-search"></i></button>
                <a class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#SP" aria-controls="offcanvasRight"><i id="iconCart" class="bi bi-cart2" style="font-size: 20px;"></i></a>
                <button class="btn" type="button"><i id="iconCircle" class="bi bi-person-circle" role="button"
                        style="font-size: 20px;" onclick="document.getElementById('Member').style.display='block'"></i></button>
            </form>
        </div>
    </nav>
</header>


<body class="mt-5 pt-4">
    <!-- 購物車 -->
    <div class="offcanvas offcanvas-end" id="SP">
        <div class="offcanvas-header">
            <h1 class="">購物車</h1>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body" style="text-align: center;">
            <div id="cart"></div>
            <div class="nocart">
                <h3>您的購物車是空的</h3>
                <h5>快去逛!買買買!!!</h5>
            </div>
            <a href="#allproduct" class="btn btn-dark mt-3"><h5 class="pt-2" data-bs-dismiss="offcanvas">繼續購物</h5></a>
            
        </div>
    </div>

    <!-- 服務條款 -->
    <div id="tyModal">
        <div class="tyModalContent">
            <span class="tyClose">&times;</span>
            <h1 style="text-align: center;" class="pb-3">服務條款</h1>
            <h5>運送方式</h5>
            <p>"賣家宅配" 預計配達時間與賣家聯絡敲定</p>
            <p>"超商寄件" 預計配達時間於寄出後約2-3工作天</p>
            <hr>
            <h5>付款方式</h5>
            <p class="d-flex">"信用卡/金融卡"<img class="ms-auto" src="./img/螢幕擷取畫面 2025-02-09 210646.png" alt="..." style="width: 10%;"></p>
            <p class="d-flex">"線上支付"<img class="ms-auto" src="./img/螢幕擷取畫面 2025-02-09 211205.png" alt="..." style="width: 10%;"></p>
            <p class="d-flex">"貨到付款"<img class="ms-auto" src="./img/螢幕擷取畫面 2025-02-18 093507.png" alt="..." style="width: 10%;"></p>
            
        </div>
    </div>
    <!-- 會員資料 -->
    <div id="Member" class="member animate">
        <form class="member-content" action="">
            <div class="container m-2">
                <img class="mb-2" src="photo.php" alt="大頭照" style="width: 20%;">
                <h3>嗨！<?=$user['name'] ?></h3>
            </div>
            <div class="d-flex justify-content-center">
                <button class="Btn"><i class="bi bi-handbag-fill"></i><br>訂單</button>
                <button class="Btn"><i class="bi bi-gear-fill"></i><br>設定</button>
            </div>
            <button class="Butt">付款方式</button>
            <button class="Butt">客服中心</button>
            <div class="d-flex"><a type="button" href= "logout.php" class="btn btn-dark m-2 d-flex justify-content-center">登出</a></div>
        </form>
    </div>
    <!-- 商品圖切換+商品資料 -->
    <div class="con m-3">
        <div class="thumbnails">
            <img src="./img/_DSC4481.JPG" alt="Thumbnail 1" onclick="changeImage(this)" class="active">
            <img src="./img/_DSC4488.JPG" alt="Thumbnail 2" onclick="changeImage(this)">
            <img src="./img/_DSC4509.JPG" alt="Thumbnail 3" onclick="changeImage(this)">
        </div>
        <div class="d-flex">
            <img id="mainImage" class="main-image" src="./img/_DSC4485.JPG" alt="主圖" style="width: 60%;">
            <div class="ms-auto" style="width: 30%;">   
                <div>
                    <h1 name="hid"><?php echo $pname; ?></h1>
                    <b name="price">$<?php echo $price; ?></b>
                    <hr>
                    <p name="label"><?php echo $label; ?></p>
                </div>    
                <div class="btn-group">
                    <button type="button" class="btn btn-dark btn-lg">&minus;</button>
                    <span class="btn btn-light btn-lg">1</span>
                    <button type="button" class="btn btn-dark btn-lg">&plus;</button>
                </div><p></p>
                <button id="sp" onclick="addToCart('<?php echo $pname; ?>')">加入購物車</button>
            </div>
        </div>
    </div>


    <!-- 商品資訊 -->
    <div class="my-5">
        <button class="accordion">商品細節</button>
        <div class="panel">
            <p name="Introduction"><?php echo $lntroduction; ?></p>
        </div>
        <button class="accordion">運送方式</button>
        <div class="panel">
            <div class="d-flex"><p class="me-4">"賣家宅配"</p><p>預計配達時間與賣家聯絡敲定</p></div>
            <div class="d-flex"><p class="me-4">"超商寄件"</p><p> 預計配達時間於寄出後約2-3工作天</p></div>
        </div>
        <button class="accordion">如何訂購</button>
        <div class="panel">
            <div class="d-flex"><p class="me-auto">"信用卡/金融卡"</p>
                <a href="" class="nav-link"><img src="./img/visa.jpg" alt="visa" style="width: 35px;">
                    <img src="./img/mastercard.jpg" alt="mastercard" style="width: 35px;"></a>
                </div>
                
            <div class="d-flex"><p class="me-auto">"線上支付"</p>
                <a href="https://pay.line.me/portal/tw/auth/login" class="nav-link"><img src="./img/LINEPAY.jpg" alt="LINEPAY" style="width: 35px;"></a>
                <a href="https://www.jkopay.com/application" class="nav-link"><img src="./img/jkopay.jpg" alt="jkopay" style="width: 35px;"></a>
            </div>
            
            <div class="d-flex"><p class="me-auto">"貨到付款"</p>
                <a href="https://myship.7-11.com.tw/home/Main" class="nav-link"><img src="./img/711.jpg" alt="7-11" style="width: 35px;"></a>
                <a href="https://fmec.famiport.com.tw/FP_Entrance" class="nav-link"><img src="./img/FamilyMart.jpg" alt="FamilyMart" style="width: 35px;"></a>
            </div>
        </div>
    </div>


    <script>
        
        // 側邊攔
        const offcanvasElementList = document.querySelectorAll('.offcanvas')
        const offcanvasList = [...offcanvasElementList].map(offcanvasEl => new bootstrap.Offcanvas(offcanvasEl))

        //會員區
        var member = document.getElementById('Member')
        window.onclick = function(event){
            if(event.target === member){
                member.style.display = "none"
            }
        }
        // 商品資訊
        var acc = document.getElementsByClassName("accordion");
        var i ;
        for(i=0; i < acc.length; i++){
            acc[i].addEventListener("click",function(){
                this.classList.toggle("active");

                var panel = this.nextElementSibling;

                if (panel.style.display === "block") {
                    panel.style.display = "none";
                } else {
                    panel.style.display = "block";
                }
            })
        }
        
        // 商品圖切換
        function changeImage(element) {
            const mainImage = document.getElementById('mainImage');
            mainImage.src = element.src;
            document.querySelectorAll('.thumbnails img').forEach(img => img.classList.remove('active'));
            element.classList.add('active');
        }

        // 服務條款
        var modalElem = document.getElementById("tyModal");
        var spanElem = document.getElementsByClassName("tyClose")[0];

        spanElem.onclick = function () {
            modalElem.style.display = "none";
        }

        
        // 購物車
        function addToCart(productName){
            let cart = document.getElementById("cart")
            let cartBody = document.querySelector(".nocart") 
                // 檢查購物車內是否已有該商品
            let existingItem = document.querySelector(`#cart div[data-product='${productName}']`)

            if (existingItem) {
                // 如果商品已存在，數量 +1
                let quantitySpan = existingItem.querySelector(".quantity")
                quantitySpan.textContent = parseInt(quantitySpan.textContent)+1
            } else { // 如果商品不存在，創建新的商品項目
                let item = document.createElement("div")
                item.className = "cart-item"
                item.setAttribute("data-product",productName) // 設定 data 屬性方便查找
                item.innerHTML = `
                <div class="d-flex">
                    <span class="product-name me-auto" style="width: 50%">${productName}</span> 
                    <button class="decrease mx-1"><i class="bi bi-dash"></i></button>
                    <span class="quantity">1</span>
                    <button class="increase mx-1"><i class="bi bi-plus"></i></button>
                    <button class="remove me-4">刪除</button></div>
                `
                // 綁定按鈕事件
                item.querySelector(".increase").addEventListener("click", function () {
                    let quantitySpan = item.querySelector(".quantity");
                    quantitySpan.textContent = parseInt(quantitySpan.textContent) + 1;
                });
                item.querySelector(".decrease").addEventListener("click", function () {
                    let quantitySpan = item.querySelector(".quantity");
                    let newQuantity = parseInt(quantitySpan.textContent) - 1;
                    if (newQuantity <= 0) {
                        let confirmDelete = confirm("此商品將被移除!");
                        if(confirmDelete){
                            item.remove(); // 如果數量為 0，移除該商品
                            checkCart();
                        }else{
                            quantitySpan.textContent = "1";
                        }
                    } else {
                        quantitySpan.textContent = newQuantity;
                    }
                });
                item.querySelector(".remove").addEventListener("click", function () {
                    item.remove(); // 直接移除商品
                    checkCart();
                });
                cart.appendChild(item);
            }
            cartBody.style.display = "none"; // 隱藏空購物車提示
        }
        
            // 檢查購物車是否為空
        function checkCart(){
            let cart = document.getElementById("cart")
            let cartBody = document.querySelector(".nocart")
            if(cart.children.length === 0){
                cartBody.style.display = "block" // 顯示購物車空訊息
            }
        }
        
    
    </script>

</body>


<footer id="footer" class="container-fluid py-3" style="background-color: black; ">
    <div class="d-flex " style="color:white;">
        <ul class="navbar-nav  me-auto">
            <h5>追蹤我們</h5>
            <li><a class="nav-link" href="https://www.facebook.com/share/1FGYcw9yzm/?mibextid=wwXIfr">FB:
                    O,Hannah黑哈那</a></li>
            <li><a class="nav-link" href="">IG: O,Hannah</a></li>
        </ul>
        <ul class="navbar-nav  me-auto">
            <h5>聯絡我們</h5>
            <li><a class="nav-link" href="https://mail.google.com/">Gmail:ohannah@gmail.com</a></li>
            <li><a class="nav-link" href="https://www.facebook.com/share/1FGYcw9yzm/?mibextid=wwXIfr">FB:
                    O,Hannah黑哈那</a></li>
            <li><a class="nav-link" href="">IG: O,Hannah</a></li>
        </ul>
        <ul class="navbar-nav me-auto">
            <h5>注意事項</h5>
            <li><a onclick="document.getElementById('tyModal')='block'" class="nav-link" href="">服務條款</a></li>
        </ul>
    </div>
    <div class="text-center mt-3" style="color: white;">
        <span style="font-size: 65px;">O,HANNAH</span>
    </div>
</footer>




</html>