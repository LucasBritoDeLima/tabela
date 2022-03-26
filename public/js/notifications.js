function closeBox(id) {
  const otherVar = id;
  //const element = document.getElementById(id);
  //element.style.display = 'none';
  $("#" + otherVar).fadeOut(500);
  return false;
}