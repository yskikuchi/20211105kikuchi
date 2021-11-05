<template>
  <div class="main">
    <div>
      <h2  class="home-title">ホーム</h2>
    </div>
    <Post class="post" v-for="post in $store.state.posts" :key="post.id" :post="post"></Post>
  </div>
</template>

<script>
  export default{
  layout:'afterLogin',
  async fetch({store}){
    await store.dispatch('getPosts');
    await store.dispatch('getFavorites');
  },
}
</script>

<style>
.main{
  width:80%;
  color:white;
}
.home-title{
  border:1px solid white;
  padding:10px;
}


</style>