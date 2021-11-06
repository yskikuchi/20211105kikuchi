<template>
  <div class="post" :post="post">
    <div class="post-line">
        <p class="post-name">
          {{post.user.name}}
          <img src="~/assets/heart.png" @click="good(post.id, $store.state.userId)">
          <span>{{countFav}}</span>
          <img v-if="checkUser"  src="~/assets/cross.png" @click="deletePost(post.id)">
          <NuxtLink :to="{name:'posts-postId-comment',params:{postId:post.id}}"><img src="~/assets/detail.png" class="post-btn"></NuxtLink>
        </p>
    </div>
    <div class="post-line">
        <p class="post-content">
          {{post.content}}
        </p>
    </div>
  </div>
</template>

<script>
export default {
  props:{
    post:{
      type:Object
    },
    currentPost:{
      type:Object
    }
  },
  data(){
    return {
      fav:null,
      doneGood:0,
    }
  },
  computed:{
    checkUser(){
      return this.$store.state.userId == this.post.user_id;
    },
    countFav(){
    const result = this.$store.getters.getCount(this.post.id);
      if(result){
        return this.fav=result.fav;
      }else{
        return this.fav = 0;
    }
    }
  },
  methods:{
    deletePost(id){
      this.$store.dispatch('deletePosts', id);
    },
    async good(post_id, user_id){
      if(this.doneGood === 1){
        return;
      }
      this.doneGood = 1;
      const sendData={
        post_id:post_id,
        user_id:user_id
      };
      const checkFavorite = this.$store.getters.getFavData(post_id, user_id);
      console.log(checkFavorite);
      if(checkFavorite){
        const favoriteId = checkFavorite.id;
        await this.$axios.delete("http://127.0.0.1:8000/api/favorite/" + favoriteId);
      } else {
        await this.$axios.post("http://127.0.0.1:8000/api/favorite", sendData);
      }
      this.$store.dispatch('getFavorites');
      this.doneGood = 0;
    },
  }
}
</script>

<style>
.post{
  padding:10px;
  border:1px solid white;
  border-top:none;
}

.post-line:first-child{
  margin-bottom: 5px;
  font-weight: bold;
}

.post img{
  height: 20px;
  margin-left: 5px;
  cursor: pointer;
  transform: translate(0,5px);
}

.post img:first-child{
  margin-right: 5px;
}
.post img:last-child{
  margin-left: 15px;
}

.post-name, .post-content{
  line-height: 20px;
}



</style>