let optionElement = document.getElementById("BrandOption");
let nameElement = document.getElementById("brandName").value;

function getMarcas() {
  $.get("/brands", (data) => {
    let brands = data.brands;
    for (let i = 0; i < brands.length; i++){
      if(optionElement.value === brands[i].name){
        $("#brandName").val(brands[i].name);
        $("#idBrand").val(brands[i].id);
        $("#brand").attr("src", "http://localhost:8000/uploads/" + brands[i].picture)
      }
    }
  });
}