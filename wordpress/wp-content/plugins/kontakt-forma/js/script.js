const contactButton = document.getElementById("posalji-kontakt");
contactButton.addEventListener("click", function (e) {
  const name = document.getElementById("userName").value.trim();
  const email = document.getElementById("email").value.trim();
  const phone = document.getElementById("phone").value.trim();
  const message = document.getElementById("message").value.trim();

  let nameError = "",
    emailError = "",
    phoneError = "",
    messageError = "";
  if (!name) {
    nameError = "Ime je obavezno. ";
  }
  if (
    !email ||
    !/^([-!#-'*+/-9=?A-Z^-~]+(\.[-!#-'*+/-9=?A-Z^-~]+)*|"([]!#-[^-~ \t]|(\\[\t -~]))+")@[0-9A-Za-z]([0-9A-Za-z-]{0,61}[0-9A-Za-z])?(\.[0-9A-Za-z]([0-9A-Za-z-]{0,61}[0-9A-Za-z])?)+/.test(
      email
    )
  ) {
    emailError += "Unesite ispravan email. ";
  }

  if (!phone || !/^\+?[0-9]{9,15}$/.test(phone)) {
    phoneError += "Unesite ispravan broj mobitela. ";
  }

  if (!message) {
    messageError += "Poruka je obavezna. ";
  }

  if (nameError && emailError && phoneError && messageError) {
    const formMessage = document.getElementById("form-message");
    formMessage.innerText = "Popunite sva polja ispravno.";
  } else if (nameError || emailError || phoneError || messageError) {
    document.getElementById("nameError").textContent = nameError;
    document.getElementById("emailError").textContent = emailError;
    document.getElementById("phoneError").textContent = phoneError;
    document.getElementById("messageError").textContent = messageError;
  } else document.getElementById("contact-form").submit();
});
