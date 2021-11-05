<template>
  <div class="main">
    <div class="comment-header">
      <h2>コメント</h2>
    </div>
    <Post :post="currentPost"></Post>
    <div class="comment-ttl">
      コメント
    </div>
    <div class="comment-wrapper" v-for="comment in comments" :key="comment.id">
      <p class="comment-name">{{comment.user.name}}</p>
      <p class="comment-content">{{comment.content}}</p>
    </div>
    <validation-observer ref="obs" v-slot="ObserverProps">
      <validation-provider v-slot="{ errors }" rules="required|max:120">
        <textarea class="comment-box" v-model="comment" name="コメント"/>
        <div class="error">{{ errors[0]}}</div>
        <button class="comment-btn" @click="reply" :disabled="ObserverProps.invalid || !ObserverProps.validated">コメント</button>
      </validation-provider>
    </validation-observer>
  </div>
</template>

<script>
export default {
  layout:'afterLogin',
  data(){
    return {
      postId: this.$route.params.postId,
      currentPost:null,
      comment:null,
      comments:[],
    }
  },
  created(){
    this.currentPost = this.$store.getters.getPostDetail(this.postId);
    console.log(this.currentPost);
    this.getComments();
  },
  async fetch({store}){
    await store.dispatch('getPosts');
    await store.dispatch('getFavorites');
  },
  methods:{
    async getComments() {
    const resData = await this.$axios.get("http://127.0.0.1:8000/api/posts/" + this.postId + "/comments");
    console.log(resData.data.data);
    this.comments = resData.data.data;
    },
    async reply(){
      const sendData ={
        content: this.comment,
        user_id: this.$store.state.userId,
        post_id: this.postId
      };
      await this.$axios.post("http://127.0.0.1:8000/api/posts/" + this.postId + "/comments", sendData);
      this.comment='';
      this.getComments();
    },
  }
}
</script>

<style>
.comment-header{
  border:1px solid white;
  padding:10px;
}


.comment-ttl{
  text-align: center;
  padding:5px;
  border:1px solid white;
  border-top:none;
}

.comment-wrapper{
  border:1px solid white;
  border-top:none;
  padding-left: 10px;
  line-height: 15px;
  padding:5px;
}
.comment-name{
  font-size: 15px;
  font-weight: bold;
  line-height: 1.5;
}
.comment-content{
  font-size: 12px;
}
.comment-box{
  display: block;
  color: white;
  height: 30px;
  width:90%;
  margin:10px auto;
  background: inherit;
  border-color: rgba(255, 255, 255, 0.582);
}

.comment-btn{
  margin:0 0 0 auto;
}
</style>