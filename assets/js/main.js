// assets/js/main.js
function confirmDelete(table, id) {
  Swal.fire({
    title: 'Are you sure?',
    text: "This action cannot be undone.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete it'
  }).then((result) => {
    if (result.isConfirmed) {
      // redirect to the correct delete endpoint
      let url = `admin/${table}/delete_${table.slice(0,-1)}.php?id=${id}`;

      // Some tables have different file names:
      // projects -> admin/projects/delete_project.php (table=projects -> singular project)
      if (table === 'about') url = `admin/about/delete_about.php?id=${id}`;
      if (table === 'skills') url = `admin/skills/delete_skill.php?id=${id}`;
      if (table === 'projects') url = `admin/projects/delete_project.php?id=${id}`;
      if (table === 'education') url = `admin/education/delete_education.php?id=${id}`;

      window.location = url;
    }
  });
}
