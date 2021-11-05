<template>
  <div class="register">
    <p>ログイン</p>
    <validation-observer ref="obs" v-slot="ObserverProps">
    <validation-provider v-slot="{errors}" rules="required">
      <input v-model="email" type="email" name="メールアドレス" placeholder="メールアドレス" required/>
      <div class="error">{{ errors[0]}}</div>
      <br>
    </validation-provider>
    <validation-provider v-slot="{ errors }" rules="required">
      <input v-model="password" type="password" name="パスワード" placeholder="パスワード" required/>
      <div class="error">{{ errors[0]}}</div>
      <br>
    </validation-provider>
    <button @click="login" :disabled="ObserverProps.invalid || !ObserverProps.validated">ログイン</button>
    </validation-observer>
  </div>
</template>

<script>
import firebase from '~/plugins/firebase'
  export default{
    layout:'beforeLogin',
    data(){
      return{
        email:null,
        password:null
      }
    },
    methods:{
      login(){
        if(!this.email || !this.password) {
          alert('メールアドレスまたはパスワードが入力されていません。')
          return
        }
        firebase.auth().signInWithEmailAndPassword(this.email, this.password)
        .then(()　=>{
          this.$router.push('/posts')
        })
        .catch((error) => {
          switch (error.code) {
            case 'auth/invalid-email':
              alert('メールアドレスの形式が違います。')
              break
            case 'auth/user-disabled':
              alert('ユーザーが無効になっています。')
              break
            case 'auth/user-not-found':
              alert('ユーザーが存在しません。')
              break
            case 'auth/wrong-password':
              alert('パスワードが間違っております。')
              break
            default:
              alert('エラーが起きました。しばらくしてから再度お試しください。')
              break
          }
        })
      }
    }
  }
</script>

<style scoped>
.register{
  width: 300px;
  margin:0 auto;
  padding:20px 0;
  background: white;
  text-align: center;
  border-radius: 10px;
}
input{
  border:1px solid rgba(19, 19, 19, 0.233);
  border-radius: 5px;
  margin:10px auto;
}
button{
  background: indigo;
  color: white;
  border-radius: 30px;
  padding:5px 15px;
  font-weight: normal;
  cursor: pointer;
}
