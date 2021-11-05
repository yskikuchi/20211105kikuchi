export const state = () => ({
  name: null,
  uid: null,
  userId:null,
  posts: [],
  favorites:[],
})

export const getters = {
  getCount: state => (id) => {
    const result = state.favorites.count.find(e => e.post_id == id);
    return result;
  },
  getFavData: state => (postId, userId) => {
    const checkFavorite = state.favorites.data.find(e => e.post_id == postId && e.user_id == userId);
    return checkFavorite;
  },
  getPostDetail: state => (id) => {
    const postDetail = state.posts.find(e => e.id == id);
    return postDetail;
  }
}

export const mutations = {
  signIn(state, payload) {
    state.name = payload.name;
    state.uid = payload.uid;
  },
  setUserId(state, payload) {
    state.userId = payload;
  },
  setPosts(state, payload) {
    state.posts = payload
  },
  setFavorites(state, payload) {
    state.favorites = payload
  }
}

export const actions = {
  async getUserId({ commit }, uid) {
    const users= await this.$axios.get("http://127.0.0.1:8000/api/users");
    const userList = users.data.data;
    console.log(userList);
    const currentUser = userList.find(v => v.firebase_uid == uid);
    console.log(currentUser);
    commit('setUserId', currentUser.id);
  },
  async getPosts({ commit }) {
    const resData = await this.$axios.get("http://127.0.0.1:8000/api/posts");
    commit('setPosts', resData.data.data);
  },
  async getFavorites({ commit }) {
    const resData = await this.$axios.get("http://127.0.0.1:8000/api/favorite");
    commit('setFavorites', resData.data);
    console.log(resData.data);
  },
  async deletePosts({ dispatch },id) {
    await this.$axios.delete("http://127.0.0.1:8000/api/posts/" + id);
    dispatch('getPosts');
  }
}