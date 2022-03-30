const placeholder = "https://socialistmodernism.com/wp-content/uploads/2017/07/placeholder-image.png?w=640";
const imageInput = document.getElementById('image');
const imagePreview = document.getElementById('preview');

imageInput.addEventListener('change', e => {
  const preview = imageInput.value ?? placeholder;
  imagePreview.setAttribute('src', preview);
})