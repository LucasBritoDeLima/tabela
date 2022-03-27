function getMarcas() {
  $.get("/brands", (data) => {
    console.log(data);
  });
}
