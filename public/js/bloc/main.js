const modifyNote = document.querySelectorAll(".edit_note_icon");

//creamos el evento para poder editar las notas
function modifyNoteEvent(){
    for(let i of modifyNote){
        i.addEventListener("click",(e)=>{

            const parent = e.target.parentElement;
            const editConten = parent.lastElementChild;
            
            if(editConten.classList[0] == "edit_note_unselected"){
                editConten.classList.remove("edit_note_unselected");
                editConten.classList.add("edit_note_container");
            }
            else{
                editConten.classList.remove("edit_note_container");
                editConten.classList.add("edit_note_unselected");
            }
        })
    }
}

const addNoteCircle = document.querySelector(".add_note_circle");
const form_container = document.querySelector(".form_container");
const formNote = document.getElementById("form_add_note");

//mostramos el formulario
function openForm(){
    addNoteCircle.addEventListener("click",e=>{

        form_container.style.display = "flex";

        formNote.style.transform = "scale(1)";
    })
}

openForm()


modifyNoteEvent();

const closeFormIcon = document.getElementById("close_form_icon");

//ocultamos el formulario
function closeForm(){
    closeFormIcon.addEventListener("click",e=>{
        form_container.style.display = "none";

        formNote.style.transform = "scale(0)";
    })
}

closeForm();

const responseContainerServer = document.querySelector(".reponse_server");
const fragment = document.createDocumentFragment();


//eliminamos todos los hijos de un contenedor
function removeCHilds(container){
    if(container.childElementCount > 0){
        while(container.firstElementChild){
            container.removeChild(container.firstChild);
        }
    }
}

//enviamos la solicitud post para crear una nota
$('#form_add_note').submit(function(event) {
    //prevenimos el comportamientos por defecto
    event.preventDefault();

    //obtenemos todos los valores del formulario
    let formData = $('#form_add_note').serialize();

    $.ajax({
        url: $('#form_add_note').attr('action'),
        type: 'POST',
        data: formData,
        //en caso de que no haya errores recargamos la pagina para que se pueda apreciar la nueva nota
        success: function(response) {
           location.reload();
        },
        //en caso de que exista un error
        error: function(xhr) {
            //eliminamos todos los hijos del contenedor de response
            removeCHilds(responseContainerServer);
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                //añadimos al contenedor cada una de las respuestas del servidor
                $.each(errors, function(key, value) {
                   showResponse("error",value);
                   responseContainerServer.appendChild(fragment);
                });
            }
            else{
                showResponse("error",xhr.responseText);
                responseContainerServer.appendChild(fragment);
            }
        }
    });
});

//creamos las etiquetas p que contendran las respuestas del servidor
function showResponse(type,value){
    let p = document.createElement("p");
    if(type == "error"){
        p.innerHTML = value;
        p.classList.add("error_response");

        fragment.appendChild(p);
    }
    else{
        p.innerHTML = value;

        p.classList.add("correct_reponse");

        fragment.appendChild(p);
    }
}

//funcion para eliminar una nota en concreto
function deleteNote(container){
    let tokenValue = container.firstElementChild.value;
    $.ajax({
        url: container.action,
        type: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': tokenValue,
        },
        //en caso de que no haya errores enviamos un mensaje correcto
        success: function(response) {
            console.log(response);
            Swal.fire({
                title: "Eliminado!",
                text: response,
                icon: "success",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Ok"
            }).then(result=>{
                if(result.isConfirmed){
                    location.reload();
                }
            });
        },
        //en caso de que exista un error
        error: function(xhr) {
            Swal.fire({
                title: "Error",
                text : xhr.responseText,
                icon : "error"
            })
        }
    });
}

//agregamos el evento para eliminar una nota
function deleteNoteEvent(){
    const deleteIcons = document.querySelectorAll(".edit_note_container_delete");

    for(let i of deleteIcons){
        i.addEventListener("click",e=>{
            let deleteForm = e.currentTarget;

            //preguntamos si esta seguro de que quiere eliminar la nota
            Swal.fire({
                title: "¿Estas seguro?",
                text: "¿Quieres eliminar la nota?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si"
              }).then((result) => {
                //eliminamos la nota
                if (result.isConfirmed) {
                deleteNote(deleteForm);
                }
              });
        })
    }
}

deleteNoteEvent();

//seleccionamos todos los botones para editar que contiene cada nota
const editNotes = document.querySelectorAll(".edit_note_container_edit");

//seleccionamos el formulario,su contenedor y el boton para cerrar el formulario
const editNoteFormContainer = document.querySelector(".form_container_edit");
const editNoteForm = document.getElementById("form_edit_note");
const closeFormEdit = document.getElementById("close_form_edit");

//agregamos el evento click para poder mostrar el formulario y poder realizar la modificacion de la nota
function editNotesEvent(){
    for(let i of editNotes){
        i.addEventListener("click",e=>{
            let firstContainer = e.currentTarget.closest(".note");
            let title = firstContainer.children[0].innerHTML;
            let content = firstContainer.children[1].innerHTML;
            let idContainer = firstContainer.id;
            
            const urlEdit = window.location.href + "/edit/" + idContainer;
            console.log(urlEdit);
            showFormEdit(urlEdit,title,content);
        })
    }
}

editNotesEvent();

//mostramos el formulario de edit
function showFormEdit(url,title,content){
    editNoteFormContainer.style.display = "flex";
    editNoteForm.action = url;

    editNoteForm.querySelector(".form_content").children[1].value = title;
    editNoteForm.querySelector(".form_content").children[3].value = content;

    editNoteForm.style.transform = "scale(1)";
}

//cerramos el formulario de edit
function closeEditForm(){
    closeFormEdit.addEventListener("click",(e)=>{
        editNoteFormContainer.style.display = "none";

        editNoteForm.style.transform = "scale(0)";
    })
}

closeEditForm();

const responseServerPutContainer = document.getElementById("response_server_put");

$("#form_edit_note").submit(function(e){
    e.preventDefault();

    let formData = $("#form_edit_note").serialize();

    let token = $("#form_edit_note").children().first();

    $.ajax({
        url : $("#form_edit_note").attr("action"),
        type : "put",
        data : formData,
        success : function(response){
            Swal.fire({
                title: "Modificacion realizada",
                text : response,
                icon : "success"
            })
        },
        error: function(xhr){
            removeCHilds(responseServerPutContainer)
            if(xhr.status == 422){
                let errors = xhr.responseJSON.errors;
                //añadimos al contenedor cada una de las respuestas del servidor
                $.each(errors, function(key, value) {
                   showResponse("error",value);
                   responseServerPutContainer.appendChild(fragment);
                });
            }
            else{
                showResponse("error",xhr.responseText);
                responseServerPutContainer.appendChild(fragment);
            }
        }
    })
})
