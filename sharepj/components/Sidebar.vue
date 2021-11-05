<template>
    <aside>
      <img class="logo" src="~/assets/logo.png">
      <p>{{$store.state.name}}としてログインしています</p>
      <ul class="sidebar-nav">
        <li class="home-btn"><NuxtLink to="/posts" class="link">ホーム</NuxtLink></li>
        <li class="logout-btn"><a class="link" @click="logout">ログアウト</a></li>
      </ul>
      <validation-observer ref="obs" v-slot="ObserverProps">
        <validation-provider v-slot="{ errors }" rules="required|max:120">
          <label for="post">シェア</label><br>
          <textarea class="post-box" name="シェア" v-model="post" type="textarea" cols="30" rows="5" />
          <div class="error">{{ errors[0]}}</div>
        </validation-provider>
          <button @click="share" :disabled="ObserverProps.invalid || !ObserverProps.validated">シェアする</button>
      </validation-observer>
    </aside>
</template>


<script>
import firebase from '~/plugins/firebase'
export default {
  data(){
    return{
    post:null,
    }
  },
  async created(){
    await firebase.auth().onAuthStateChanged((user)=>{
      console.log(user);
    this.$store.commit('signIn',{name:user.displayName, uid:user.uid});
    this.$store.dispatch('getUserId', user.uid);
    });
  },
  methods:{
    logout(){
      firebase.auth().signOut().then(()=>{
        console.log("logoutしました");
        this.$router.replace('/login');
      })
    },
    async share(){
      const sendData ={
        content: this.post,
        user_id: this.$store.state.userId,
      };
      await this.$axios.post("http://127.0.0.1:8000/api/posts", sendData);
      this.post='';
      this.$store.dispatch('getPosts');
    },
  }
}
</script>

<style>

aside{
  width:20%;
}

p{
  color:white;
}
.sidebar-nav{
  margin:10px auto 20px 25px;
  line-height: 1.5;
}

.logo{
  width:50%;
  padding:10px;
}
.home-btn, .logout-btn{
  font-size:15px;
}

.link{
  cursor: pointer;
}

.home-btn::before{
  content: "";
  background:no-repeat url(~/assets/home.png);
  background-size: contain;
  width: 30px;
  height: 25px;
  display: inline-block;
  transform: translate(-25%, 25%);
}

.logout-btn::before{
  content: "";
  background:no-repeat url("~/assets/logout.png");
  background-size: contain;
  width: 30px;
  height: 25px;
  display: inline-block;
  transform: translate(-25%, 25%);
}


label{
  color:white;
  padding-left:10px;
}
.post-box{
  background: inherit;
  border-color: rgba(255, 255, 255, 0.507);
  color:white;
  width: 80%;
  margin-top:10px;
}

.error{
  color: red;
}

button{
  display: block;
  background: indigo;
  color: white;
  border-radius: 30px;
  padding:5px 15px;
  font-weight: normal;
  cursor: pointer;
}

</style>