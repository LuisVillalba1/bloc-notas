const checkBox= document.querySelector(".checkbox_password");
const passwordInput = document.getElementById("password");

//mostramos la contraseña en caso de ser deseada
function showPassword(){
    checkBox.addEventListener("click",(e)=>{
        if(e.target.checked == true){
            passwordInput.type = "text";
        }
        else{
            passwordInput.type = "password";
        }
    })
}

showPassword();