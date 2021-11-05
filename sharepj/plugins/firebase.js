import firebase from 'firebase'

if (!firebase.apps.length) {
  firebase.initializeApp(
    {
    apiKey: "AIzaSyCXSutWwPDxbdkLk05eon6LNAyVFkKdSiY",
    authDomain: "sharepj-99d6b.firebaseapp.com",
    projectId: "sharepj-99d6b",
    storageBucket: "sharepj-99d6b.appspot.com",
    messagingSenderId: "1030043670319",
    appId: "1:1030043670319:web:0563628d14b3dbbd1a73da",
    measurementId: "G-X3QLDLGSL8"
    }
  )
}
  
export default firebase