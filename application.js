var registerBtn=document.getElementById('register-link');
var formDiv=document.getElementById('form-div');
var users_no=document.getElementById('users-no');
var login_form= document.getElementById('login-form');
var register_form=document.getElementById('register-form');
var main_display=document.getElementById('main-l');
let user_info=document.getElementById('user-info');







function display_register_form(){
    let request=new XMLHttpRequest();
    request.open('GET','views/forms.php?form=register');
    request.send();
    request.onreadystatechange=function (){
        if(this.readyState==4 && this.status==200) {
            formDiv.innerHTML=this.responseText;
        }
    };

    
}


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





//functions are called from inline onsubmit attriute
function register_user(){
   
    let username=document.getElementById('username').value;
    let email=document.getElementById('email').value;
    let password=document.getElementById('password').value;
    let confirm_password = document.getElementById('confirm-password').value;
    
    //add form validation code here
    if(username && email && password){
        if(password===confirm_password){

            let request = new XMLHttpRequest();
            request.open('post','actions.php');
            request.setRequestHeader("content-type","application/x-www-form-urlencoded");
            request.onreadystatechange=function(){
                if(this.status==200 && this.readyState==4){
                    //reload index page
                    let response=JSON.parse(this.response);
                    if(response=='registered successfully'){
                        document.getElementById('message').innerText=response; 
                        setTimeout(reload,1500);
                    }
                    console.log(33445);
                    console.log(document.getElementById('message'));
                    console.log(response);
                    
                }
                
            };
            request.send("action=register&username="+username+"&email="+email+"&password="+password);
        }else{
            document.getElementById('message').innerText='passwords do not match';
       }
    }else{
        document.getElementById('message').innerText='all fields are required';
    }
}


function log_user_in(){
    //event.prevantDefault();
    let username=document.getElementById('username').value;
    let password=document.getElementById('password').value;

    if(username && password){
        let request= new XMLHttpRequest();
        request.open('POST',"actions.php",);
        request.setRequestHeader('content-type','application/x-www-form-urlencoded');
        request.onreadystatechange=function(){
            if(this.readyState==4 && this.status==200){
                
                // console.log(this.responseText);
            
                if(JSON.parse(this.responseText)=='success'){
                    reload();
                    
                }else{
                    alert('could not login');
                }
            }
            
        };

        request.send("action=login&username="+username+"&password="+password);
    }else{
        document.getElementById('message').innerText='All fields are required';
    }
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
            if(response.length !== 0){
                
                display_images(response);
                
               
            }else{
               
                    let message = document.createElement('p');
                    message.innerText='No image to display';
                    message.classList+=' no-image-message';
                    main_display.innerHTML="";
                    main_display.appendChild(message);
                
            }
             
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

            //adding slide sow event listener to image
            image.addEventListener('click',show_slide);

            //adding class to container
            container.classList+=' image-container';

        //appending image and details
        container.appendChild(image);
        container.appendChild(data);
        
        
        //appending to document fragment
        fragment.appendChild(container);
        
        //no need for this
        //document.getElementsByClassName('no-image-message')[0].style.display='none';

        }
        //appending to image display
        let image_wrap=document.createElement('div');
        image_wrap.classList+=' main-l-images';
        image_wrap.appendChild(fragment);

        //finally appending to page
        

            main_display.innerHTML='';
            main_display.appendChild(image_wrap);
            //console.log(image_wrap);
        
    
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





//adding event functions to account actions

let change_password=document.getElementById('change-password');
let delete_account=document.getElementById('delete-account');
let logout=document.getElementById('logout');

change_password.addEventListener('click',display_password_form);
delete_account.addEventListener('click',delete_account_function);
logout.addEventListener('click',logout_function);

function display_password_form(){
    let request= new XMLHttpRequest();
    request.open('GET','views/forms.php?form=change_password');
    
    request.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){
            let form=document.createElement('div');
            form.classList+=' form-div-password';
            form.innerHTML= this.response;
            
            //emptying main display
            main_display.innerHTML='';

            main_display.appendChild(form)
        }
    };
    request.send();
}

function change_user_password(){
    let old_password = document.getElementById('old-password').value;
    let new_password = document.getElementById('new-password').value;
    let confirm_password = document.getElementById('confirm-password').value;
    let message=document.getElementById('message');
    let id=get_user_id();

    if(new_password===confirm_password){
        let request=new XMLHttpRequest();
        request.open('POST','actions.php');
        request.setRequestHeader('content-type','application/x-www-form-urlencoded');
        request.onreadystatechange=function(){
            if(this.status==200 && this.readyState==4){
                let response=JSON.parse(this.response);
                message.innerText=response;
                if(response=='password updated'){
                    setTimeout(reload,1000);
                }
                
            }
        };
        request.send('action=update_password&old_pass='+old_password+'&new_pass='+new_password+'&cpass='+confirm_password+'&id='+id);

    }else{
        message.innerText='passwords do not match';
    }

}

function reload(){
    location.reload();
}

function delete_account_function(){
    let delete_promt= confirm('Do you want to delete account?');
    if(delete_promt){
        let request= new XMLHttpRequest();
        request.open('POST','actions.php');
        request.setRequestHeader('content-type','application/x-www-form-urlencoded');
        request.onreadystatechange=function(){
            if(this.status==200 && this.readyState==4){
                alert(JSON.parse(this.response));
                if(JSON.parse(this.response)=='account deleted'){
                    setTimeout(reload,1000);
                }else{
                    alert('could not delete account');
                }
            }
        };
        let id=get_user_id();
        request.send('action=delete_account&id='+id);
    }
}

function logout_function(){
    let logout_promt=confirm('do you want to logout?');
    if(logout_promt){
        let request=new XMLHttpRequest();
        request.open('POST','actions.php');
        request.onreadystatechange=function(){
            if(this.readyState==4 && this.status==200){
                alert(JSON.parse(this.response));
                setTimeout(reload,0500);
            }
        };
        request.setRequestHeader('content-type','application/x-www-form-urlencoded');
        request.send('action=logout');
    }
}




//variabe to store images, tp be used in slideshow instantiated in load images function
let images_;



//variable to store current mage in slide
let current_image;

function set_index(image){
   
    for(let i=0; i<images_.length;i++){
       
        
        if(images_[i]==image){
            
            current_image=i;
            
        }
    }
    
}

function hide_slide(){
    document.getElementById('slide').style.display="none";
}

function show_slide(event){

    images_=document.getElementById('main-l').querySelectorAll('img');
    
    
    set_index(event.target);
    let slide=document.getElementById('slide');
    slide.style.display="flex";
    
    show_image(event.target);
    
}

function show_image(image){
    
    let slide_image=document.getElementById('slide-image');
    slide_image.style.backgroundImage='url('+image.src+')';
    
}

function next_slide(){
    current_image+=1;

   if(current_image==images_.length){
       current_image=0;
   }
  
   show_image(images_[current_image]);
}

function previous_slide(){
    

   if(current_image==0){
       current_image= (images_.length -1);
   }else{
    current_image-=1;
   }

   show_image(images_[current_image]);
}

