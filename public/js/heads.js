function openModal(head) {
  $(".modal-container").fadeIn();
  $(this).css({ "z-index": 99 });
  $(".overlay").fadeIn(1000);
  const formData = document.querySelector("#form-car-new");
  formData.addEventListener("submit", (event) => {
    event.preventDefault();
  });
  $.get("/heads", (data) => {
    let heads = data.heads;
    $("#head-span").text(heads[head-1].name_engine);
    $("#name-head").val(heads[head-1].name_engine);
    $("#head-fuel").val(heads[head-1].fuel);
    $("#material-head").val(heads[head-1].material_kind);
    $("#std-head").val(heads[head-1].standard_height);
    $("#min-head").val(heads[head-1].minimum_height);
    $("#obs-head").val(heads[head-1].observation);
  });
}

function closeModal() {
  $(".modal-container").fadeOut();
  $(".overlay").fadeOut(1000);
  $(this).css({ "z-index": 1 });
}

$(document).ready(
  () => {
    $.get("/heads", (data) => {
      let heads = data.heads;
      let tableHead = $("#table-heads");
      tableHead.empty();
      for (let i = 0; i < heads.length; i++) {
        // console.log(heads[i].name_engine);
        tableHead.append(`<tr>
          <td class="title-car">${heads[i].name_engine}</td>
          <td class="btn-align">
            <button class="btn-info" onclick="openModal('${heads[i].id}')">Info</button>
            <button class="btn-edit" onclick="">Editar</button>
            <button class="btn-del" onclick="">Apagar</button>
          </td>
        </tr>`);
      }
    });
  }
);