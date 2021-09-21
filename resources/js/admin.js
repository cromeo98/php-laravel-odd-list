require('./bootstrap');

const deletePost = document.querySelectorAll('.delete-post');

deletePost.forEach(item => {
    item.addEventListener('submit', function(e){
        const resp = confirm('Vuoi veramente cancellare il post?');

        if(!resp){
            e.preventDefault();
        }
    });
});