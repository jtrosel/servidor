import { obtenerUsuarios, $ } from "./users/functions.js";

document.addEventListener("DOMContentLoaded", () => {
  const button = $("#get_users");

  button.addEventListener("click", () => {
    obtenerUsuarios();
  });
});
