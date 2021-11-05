<template>
  <div class="register">
    <p>新規登録</p>
    <validation-observer ref="obs" v-slot="ObserverProps">
      <validation-provider v-slot="{errors}" rules="required|max:8">
        <input v-model="name" name="ユーザーネーム" type="text" placeholder="ユーザーネーム">
        <div class="error">{{ errors[0]}}</div>
        <br>
      </validation-provider>
      <validation-provider v-slot="{errors}" rules="required|email">
        <input v-model="email" name="メールアドレス" type="email" placeholder="メールアドレス" />
        <div class="error">{{ errors[0] }}</div>
        <br>
      </validation-provider>
      <validation-provider v-slot="{errors}" rules="required|min:6">
        <input v-model="password" name="パスワード" type="password" placeholder="パスワード"/>
        <div class="error">{{ errors[0] }}</div>
        <br>
      </validation-provider>
      <button @click="register" :disabled="ObserverProps.invalid || !ObserverProps.validated">新規登録</button>
    </validation-observer>
  </div>
</template>

<script>
  import firebase from '~/plugins/firebase'
  export default{
    layout:'beforeLogin',
    data(){
      return{
        name:null,
        email:null,
        password:null,
        uid:null
      }
    },
    methods:{
        register(){
        if(!this.name || !this.email || !this.password){
          alert('ユーザーネーム、メールアドレス、パスワードのいずれかが入力されていません。')
          return
        };
        firebase.auth().createUserWithEmailAndPassword(this.email, this.password)
        .then(result =>{
          result.user.updateProfile({
          displayName: this.name,
          });
          this.uid=result.user.uid;
          const sendData={
            name:this.name,
            email:this.email,
            firebase_uid:this.uid,
          };
          this.$axios.post("http://127.0.0.1:8000/api/users", sendData);
          })
        .then(()=>{
          this.$router.replace('/login')
        })
        .catch((error) => {
          switch (error.code) {
            case 'auth/invalid-email':
              alert('メールアドレスの形式が違います。')
              break
            case 'auth/email-already-in-use':
              alert('このメールアドレスはすでに使われています。')
              break
            case 'auth/weak-password':
              alert('パスワードは6文字以上で入力してください。')
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

<style>
.register{
  width: 300px;
  margin:0 auto;
  padding:20px 0;
  background: white;
  text-align: center;
  border-radius: 10px;
}
.error{
  color: red;
}
input{
  border:1px solid rgba(19, 19, 19, 0.233);
  border-radius: 5px;
  margin:10px auto;
}
button{
  margin:5px auto;
  background: indigo;
  color: white;
  border-radius: 30px;
  padding:5px 15px;
  font-weight: normal;
  cursor: pointer;
}

</style>