/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
                    
                $("#contactSubmitButton").click(function(){
                    var frm=$("#contactForm").serialize();//serializo el formulario
                    //para no estar concatenando campos de clave y usuario.
                        $.ajax({ 
                        type:"POST",
                        url:"index.php",
                        data:frm,
                        dataType:'json',
                        cache:false,
                        success:function(response){ 
                            if(response.estado=="1"){                                
                               window.location = response.url;
                           
                            }
                            
                            else if (response.estado=="2"){
                                
                               $("#div_mensaje_rojo").show();
                               
                            }
                            else{ //si 0 porque no se pudo elimnar
                               $("#div_mensaje_azul").show();
                               
                            }  
                        } 
                    }); 
                   
                });
                    
                });

