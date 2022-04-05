const placeholder = "https://socialistmodernism.com/wp-content/uploads/2017/07/placeholder-image.png";
const imageInput = document.getElementById('image');
const imagePreview = document.getElementById('preview');

imageInput.addEventListener('change', () => {
  //<Controllo se un file è stato effettivamente caricato
  if(imageInput.files && imageInput.files[0]){
    let reader = new FileReader();
    reader.readAsDataURL(imageInput.files[0]);

    reader.onload = (e) => {
      imagePreview.setAttribute('src', e.target.result);
    }
  }else imagePreview.setAttribute('src', placeholder);
})