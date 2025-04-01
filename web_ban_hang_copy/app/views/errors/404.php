<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            color: #2c3e50;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        
        .error-container {
            width: 100%;
            max-width: 800px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(50, 50, 93, 0.1), 0 5px 15px rgba(0, 0, 0, 0.07);
            padding: 60px;
            text-align: center;
            position: relative;
            z-index: 10;
            animation: fadeIn 0.8s ease-out;
        }
        
        .error-code {
            font-size: 160px;
            font-weight: 900;
            background: linear-gradient(45deg, #fa8231, #fc5c65);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            line-height: 1;
            margin-bottom: 20px;
            text-shadow: 3px 3px 0 rgba(250, 130, 49, 0.1);
        }
        
        .error-title {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #2d3436;
        }
        
        .error-message {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 40px;
            color: #636e72;
        }
        
        .home-button {
            display: inline-block;
            padding: 16px 32px;
            font-size: 18px;
            font-weight: 600;
            background: linear-gradient(45deg, #fa8231, #fc5c65);
            color: white;
            border-radius: 50px;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(252, 92, 101, 0.4);
            transition: all 0.3s ease;
        }
        
        .home-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 20px rgba(252, 92, 101, 0.5);
        }
        
        .shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
        
        .shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.2;
        }
        
        .shape-1 {
            width: 300px;
            height: 300px;
            background: linear-gradient(#fc5c65, #fa8231);
            top: -100px;
            right: -100px;
        }
        
        .shape-2 {
            width: 200px;
            height: 200px;
            background: linear-gradient(#a55eea, #8854d0);
            bottom: -50px;
            left: -50px;
        }
        
        .shape-3 {
            width: 150px;
            height: 150px;
            background: linear-gradient(#20bf6b, #0fb9b1);
            bottom: 150px;
            right: 100px;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .broken-robot {
            width: 150px;
            height: 150px;
            background: url('/api/placeholder/150/150') no-repeat center center;
            background-size: contain;
            margin: 0 auto 30px;
        }
    </style>
</head>
<body>
    <div class="shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>
    
    <div class="error-container">
        <div class="broken-robot"></div>
        <div class="error-code">404</div>
        <h1 class="error-title">Trang không tìm thấy!</h1>
        <p class="error-message">Rất tiếc, trang bạn đang tìm kiếm không tồn tại hoặc bạn không có quyền truy cập vào trang này.</p>
        <a href="/web_ban_hang_copy/" class="home-button">Trở về trang chủ</a>
    </div>
</body>
</html>