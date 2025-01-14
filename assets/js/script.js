// Toggle Input Type and Class Password
const togglePassword = document.querySelector('#togglePassword');
const password = document.querySelector('#id_password');

togglePassword.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    // toggle the eye slash icon
    this.classList.toggle('fa-eye');

    if(this.classList.contains('fa-eye' && 'fa-eye-slash')){
        this.classList.remove('fa-eye-slash');
      }else{
        this.classList.add('fa-eye-slash');
      }
});