<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /*reset web page*/
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }
        /*styling the body*/
body{
    flex-direction: column;
    display: flex;
    background-color: #1e171fff;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 20px;

}
/*form styling*/
.form{

    background: #fff;
    padding: 25px;
    border-radius: 10px;
    width: 450px;
     box-shadow: 0 4px 8px rgba(0,0,0,0.2);

}
label{
    font-weight: bold;
    color: #333;

}
input{
    width: 100%;
    padding: 12px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 14px;
}
h2 {
    color: #a89393ff;
    display: contents;
    text-align: center;
    width: 100%;
    max-width: 400px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}
button{
    width: 100%;
    padding: 12px;
    background-color: blueviolet;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s ease;
}
button:active{
    transform:scale(0.85) ;
}
button:hover{
    background-color: black;
}
    </style>
</head>
<body>
     <h2>WELCOME BACK ADMIN</h2>
    <form onsubmit="formValidation()"  class="form" action="" method="">
    
    <label for="email">Enter email</label><br>
    <input type="email" id="email" name="email" placeholder="enter your email address"><br><br>
    <label for="password">Enter your password</label><br>
    <input type="password" id="password" name="password" placeholder="enter your pass"><br><br>
    <button type="submit"  class="btn">login</button>
    </form>
    <script>
        function formValidation(){
            let email = document.getElementById("email").value.trim();
            let password = document.getElementById("password").value.trim();

            //check  empty fields
            if(email===""){
                alert("email is required");
                return false;
            }
            if(password===""){
                alert("password is required")
                return false;
            }

            if(password.length < 6) {
                alert("password must have atleast 6 characters");
            }
             return true;
        }
    </script>
</body>
</html>