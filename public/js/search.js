function openModal(name,data) {
  $(".modal-container").fadeIn();
  $(this).css({ "z-index": 99 });
  $(".overlay").fadeIn(1000);
  $("#oldName").val(name);
  $("#nameOriginal").val(data);
  const formData = document.querySelector("#form-car-new");
  formData.addEventListener("submit", (event) => {
    event.preventDefault();
  });
}

function closeModal() {
  $(".modal-container").fadeOut();
  $(".overlay").fadeOut(1000);
  $(this).css({ "z-index": 1 });
}

function waitTime(){
  $("#table-cars").empty();
  closeModal();
}

function sendData(){
  let id = document.getElementById("nameOriginal").value;
  let newName = document.getElementById("newName").value;
  $.ajax({
    url: '/app/edit-car',
    type: 'POST',
    data: {
      newName: newName,
      nameOriginal: id,
    },
    success: (res) => {
      $("#message").empty();
      $("#message").append(`<span class="message-ok"><b>Modelo editado com sucesso</b></span>`);
      $("#message").fadeOut(3000);
      const wait = setTimeout(waitTime, 500);
    },
    error: (error) => {
      alert("SÓ LAMENTO");
    }
  })
}

const formElement = document.querySelector("form");
formElement.addEventListener("submit", (event) => {
  event.preventDefault();
  let uri = "/car?name=" + $("#brandName").val();
  $.getJSON(uri, (data) => {
    let brands = [];
    $("#table-cars").empty();
    $(data).each((key, value) => {
      $("#table-cars").append(`<tr>
      <td class="title-car">${value.name_car}</td>
      <td class="btn-align">
        <button class="btn-edit" onclick="openModal('${value.name_car}','${value.id}')">Editar</button>
        <button class="btn-del">Apagar</button>
      </td>
      </tr>`);
    });
  }).fail(() => {
    $("#table-cars").empty();
    $("#table-cars").append(
      `<h1 style='color: red'>Não existem dados para essa montadora!</h1>`
    );
  });
});

$(".btn-edit").on("click", () => {});

$(() => {
  $.getJSON("/brand", (data) => {
    let items = [];

    $(data).each((key, value) => {
      items.push(value.name);
    });

    $("#brandName").autocomplete({
      source: items,
    });
  });
});
