<template>
    <div>
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">{{post.title}}</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name:"Main",
    data(){
        return{
            chiamataApi: '127.0.0.1:8000/api/posts',
            posts: []
        }
    },
    created(){
        console.log(this.chiamataApi);
    },
    // methods:{
    //     getPosts(){
    //         axios.get(this.chiamataApi)
    //         .then(response => {
    //             console.log(this.chiamataApi);
                
    //         })
    //         .catch();
    //     }
    // }
}
</script>