var file1 = document.getElementById("file1");
var brand = document.getElementById("brand");

file1.onchange = evt => {
  const [file] = file1.files;
  if (file) {
    brand.src = URL.createObjectURL(file);
  }
}