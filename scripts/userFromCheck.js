// let users = [
//   {
//     username: "Amit1234",
//     password: "1234567890",
//     mobile: "0909090909",
//     email: "abc@xyz.com",
//   },
//   {
//     username: "Ravi5678",
//     password: "9876543210",
//     mobile: "0808080808",
//     email: "ravi@email.com",
//   },
//   {
//     username: "Neha001",
//     password: "password123",
//     mobile: "0707070707",
//     email: "neha@email.com",
//   },
//   {
//     username: "Suman_45",
//     password: "sumanpass45",
//     mobile: "0606060606",
//     email: "suman@email.com",
//   },
//   {
//     username: "Rahul999",
//     password: "rahulsecure",
//     mobile: "0505050505",
//     email: "rahul@email.com",
//   },
// ];

document.getElementById("reg_form").addEventListener("submit", function (event) {
  if (!validateForm(event)) {
    event.preventDefault(); 
  }
});

function validateForm(event) {
  // event.preventDefault();
  let username = document.getElementById("name").value;
  let password = document.getElementById("pass1").value;
  let confirmPassword = document.getElementById("pass2").value;
  let mobile = document.getElementById("mob").value;
  let email = document.getElementById("email").value;
  let address = document.getElementById("address").value;
  let district = document.getElementById("District").value;
  let state = document.getElementById("State").value;

  // Regular Expressions
  let usernameRegex = /^[a-zA-Z0-9]{3,15}$/;
  let passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
  let mobileRegex = /^[0-9]{10}$/;
  let emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
  let textOnlyRegex = /^[A-Za-z\s]+$/;

  if (!usernameRegex.test(username)) {
    alert(
      "Username must be 3-15 characters long and contain only letters & numbers."
    );
    return false;
  }
  if (!passwordRegex.test(password)) {
    alert(
      "Password must be at least 8 characters long, with at least 1 letter and 1 number."
    );
    return false;
  }
  if (password !== confirmPassword) {
    alert("Passwords do not match!");
    return false;
  }
  if (!mobileRegex.test(mobile)) {
    alert("Mobile number must be exactly 10 digits.");
    return false;
  }
  if (!emailRegex.test(email)) {
    alert("Invalid email format.");
    return false;
  }
  if (address.trim() === "") {
    alert("Address cannot be empty.");
    return false;
  }
  if (!textOnlyRegex.test(district)) {
    alert("District name should contain only letters.");
    return false;
  }
  if (!textOnlyRegex.test(state)) {
    alert("State name should contain only letters.");
    return false;
  }

//   function check(uname, mobile, email) {
//     let userExists = users.find(
//       (user) =>
//         user.username === uname ||
//         user.mobile === mobile ||
//         user.email === email
//     );
//     return userExists ? true : false;
//   }

//   if (check(username, mobile, email)) {
//     alert("Username , Mobile or Email already Exist !");
//     return false;
//   }

  alert("Registration Successful!");
  return true;
}
