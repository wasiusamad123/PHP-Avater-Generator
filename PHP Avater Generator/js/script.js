function submitForm() {
  const username = document.getElementById('username').value;
  const email = document.getElementById('email').value;
  const password = document.getElementById('password').value;
  const confirmPassword = document.getElementById('confirm-password').value;
  
  if (password !== confirmPassword) {
    alert("Passwords don't match!");
    return;
  }
  
  const canvas = document.getElementById('avatar');
  const ctx = canvas.getContext('2d');
  
  // Generate random background color
  const colors = ['#FF6633', '#FFB399', '#FF33FF', '#FFFF99', '#00B3E6', 
                  '#E6B333', '#3366E6', '#999966', '#99FF99', '#B34D4D'];
  const backgroundColor = colors[Math.floor(Math.random() * colors.length)];
  ctx.fillStyle = backgroundColor;
  ctx.fillRect(0, 0, canvas.width, canvas.height);
  
  // Draw username initials
  const initials = username.match(/\b\w/g) || [];
  const avatarText = initials.join('').toUpperCase();
  const fontSize = canvas.width / 2;
  ctx.font = fontSize + 'px Arial';
  ctx.fillStyle = 'white';
  ctx.textAlign = 'center';
  ctx.textBaseline = 'middle';
  ctx.fillText(avatarText, canvas.width / 2, canvas.height / 2);
}