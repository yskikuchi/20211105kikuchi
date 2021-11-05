<template>
  <header>
    <img src="~/assets/logo.png">
    <nav class="header-nav">
      <ul class="header-nav-list">
        <li><NuxtLink to="/register" class="link">新規登録</NuxtLink></li>
        <li><NuxtLink to="/login" class="link">ログイン</NuxtLink></li>
      </ul>
    </nav>
  </header>
</template>

<style>
header{
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 80px;
}
header img{
  height: 50px;
}
.header-nav-list{
  display: flex;
}
.link{
  color: white;
  text-decoration: none;
  padding-right: 30px;
}
</style>