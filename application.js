var registerBtn=document.getElementById('register-link');
var formDiv=document.getElementById('form-div');
var users_no=document.getElementById('users-no');
var login_form= document.getElementById('login-form');
var register_form=document.getElementById('register-form');
var main_display=document.getElementById('main-l');
let user_info=document.getElementById('user-info');




window.onload=function(){
    let request=new XMLHttpRequest();
    request.open('GET','views/forms.php?form=login');
    request.send();
    request.onreadystatechange=function(){
        if(this.status==200 && this.readyState ==4){
            formDiv.innerHTML=this.responseText;
        }
    };

};
console.log(5);
window.addEventListener('load',get_users_no);

function get_users_no(){
    let request=new XMLHttpRequest();
    request.open('GET','actions.php?request=get_users_no');
    request.send();
    request.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){
            let users=JSON.parse(this.responseText);
            let string='';
            if(users==0){
                string='Be the first to use this site';
            }else if(users==1){
                string='Be the second person to use this site';
            }else {
                string='join '+users+' people using this site';
            }
           
            users_no.innerText=string;
            
        
        }
    };
}
console.log(9);
// registerBtn.addEventListener('click',function(){
//     let request=new XMLHttpRequest();
//     request.open('GET','views/forms.php?form=register');
//     request.send();
//     request.onreadystatechange=function (){
//         if(this.readyState==4 && this.status==200) {
//             formDiv.innerHTML=this.responseText;
//         }
//     };

    
// });

console.log(12);

//functions are called from inline onsubmit attriute
function register_user(){
   
    let username=document.getElementById('username').value;
    let email=document.getElementById('email').value;
    let password=document.getElementById('password').value;
    let confirm_password = document.getElementById('confirm-password').value;
    
    //add form validation code here

    let request = new XMLHttpRequest();
    request.open('post','actions.php');
    request.setRequestHeader("content-type","application/x-www-form-urlencoded");
    request.onreadystatechange=function(){
        if(this.status==4 && this.readyState==200){
            //reload index page
            console.log(this.responseText);
           
        }
        
    };
    request.send("action=register&username="+username+"&email="+email+"&password="+password);
   
}

console.log(9);
function log_user_in(){
    //event.prevantDefault();
    let username=document.getElementById('username').value;
    let password=document.getElementById('password').value;

    let request= new XMLHttpRequest();
    request.open('POST',"actions.php",);
    request.setRequestHeader('content-type','application/x-www-form-urlencoded');
    request.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){
            
            // console.log(this.responseText);
        
             if(this.responseText=='success'){
                 //location.reload();
                 console.log('tested success');
             }else{
                 alert('could not login');
             }
        }
        
    };

    request.send("action=login&username="+username+"&password="+password);

}

//view form event event handler
function load_images (){
    let view=document.getElementById('view').value;
    let id=get_user_id();
    let query=(view==1)? 'get_user_image&id='+id : 'get_all_images' ;


    let request =new XMLHttpRequest();
    request.open('GET','actions.php?request='+query)
    request.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){
            
            let response=JSON.parse(this.response);
            display_images(response);
            // console.log(response);
        }
    };
    request.send();

}

window.addEventListener('load',get_user_details);

function get_user_details(){
    let request = new XMLHttpRequest();
    request.open('GET','actions.php?request=get_user_details');
    request.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){
            let response=JSON.parse(this.response);

            //putting response on page
            let username=document.getElementById('username') ;
                username.innerText="WELCOME "+response.username;
            let user_id=document.getElementById('id-no') ;
                user_id.innerText=response.id;

        }
    };

    request.send();
}



function get_user_id(){
    let id=document.getElementById('id-no').innerText;
    return id;
}

function display_images(image_array){
    let fragment=document.createDocumentFragment();
    
    for(let i=0; i<image_array.length;i++){
        console.log(image_array[i]['image_name']);
        console.log(image_array[i]['id']);
        console.log(image_array[i]['posted_at']);
        console.log(image_array[i]['user_id']);
    let container=document.createElement('div');
    let image=document.createElement('img');
    let data=document.createElement('div');
    let time=document.createElement('span');
    let user =document.createElement('span');
    image.src='images/uploaded_images/'+image_array[i]['image_name'];
    time.innerText="posted at "+image_array[i]['posted_at'];

    //

    if(image_array[i]['user_id']==get_user_id()){
        user.innerText='posted by you';
    }else{
        user.innerText='posted by '+image_array[i]['username'];
    }
    

        
     //appending image details
     data.appendChild(time);
     data.appendChild(user);
     
        //adding class to image data
        data.classList+=' image-data';

        //adding class to image
        image.classList+=' image-image';

        //adding class to container
        container.classList+=' image-container';

     //appending image and details
     container.appendChild(image);
     container.appendChild(data);
     
     //appending to document fragment
     fragment.appendChild(container);
     

    }
    //appending to image display
    let image_wrap=document.createElement('div');
    image_wrap.classList+=' main-l-images';
    image_wrap.appendChild(fragment);

    //finally appending to page
    

    let existing=document.getElementsByClassName('main-l-images');
   console.log(existing);
    if(existing.length>0){
        main_display.replaceChild(image_wrap,existing[0]);
    }else{
        main_display.appendChild(image_wrap);
    }
}


let upload=document.getElementById('upload-picture');


upload.addEventListener('click',function(event){
    event.preventDefault();

    let request=new XMLHttpRequest();
    request.open('GET','views/forms.php?form=image_upload');
    request.onreadystatechange=function(){
        
        if(this.readyState==4 && this.status==200){
            main_display.innerHTML=this.response;
    
        }
    };
    request.send();
});

function upload_image(){
    
    

    //refrencing upload image form
    let form_element=document.getElementById('upload-image-form');

    //creating form data object
    let form= new FormData(form_element);
    form.append('action','insert_image');
    
    let request=new XMLHttpRequest();
    request.open('POST','actions.php');
    request.onreadystatechange=function(){
       if(this.readyState==4 && this.status==200){
        alert(JSON.parse(this.responseText));
        location.reload();
       }
        
    };
    request.send(form);

}


//set timeout to get and display user details
setTimeout(load_images,0500);



