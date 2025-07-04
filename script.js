// JavaScript Example (frontend logic)
const role = document.querySelector("select[name='role']").value;
if (role === 'student') window.location.href = 'studentDashboard.html';
else if (role === 'mentor') window.location.href = 'mentorDashboard.html';
else if (role === 'supervisor') window.location.href = 'supervisorDashboard.html';
