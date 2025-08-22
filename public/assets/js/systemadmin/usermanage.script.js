import { ROOT } from '../main.script.js';

document.getElementById('sidebarToggle').addEventListener('click', function () {
    document.querySelector('.sidebar').classList.toggle('collapsed');
    document.querySelector('.main-content').classList.toggle('expanded');
});

document.querySelector('.sidebar-toggle').addEventListener('click', function (e) {
    if (e.target.textContent.trim() === ">") {
        e.target.textContent = "<";
    } else {
        e.target.textContent = ">";
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link');

    navLinks.forEach(link => {
        if (link.getAttribute('href').includes(currentPath)) {
            navLinks.forEach(l => l.classList.remove('active'));
            link.classList.add('active');
        }
    });
});

function editUser(userId) {
    const modal = document.getElementById('editUserModal');
    modal.style.display = 'flex';
    modal.classList.add('show');

    const modalContent = modal.querySelector('.modal-content');
    modalContent.setAttribute('tabindex', '-1');
    modalContent.focus();
    // console.log(userId);

    fetchUserData(userId);
    updateUserData(userId);

}

function fetchUserData(userId) {
    // Simulate loading state
    // const modalBody = document.querySelector('.modal-body');
    // modalBody.classList.add('loading');


    fetch(`${ROOT}/systemadmin/updateuser`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'user_id=' + encodeURIComponent(userId) + '&action=fetch'
    })
        .then(response => response.json())
        .then(data => {
            // console.log(data)
            if (data.success) {
                document.getElementById('edit_first_name').value = data.user[0].full_name.trim().split(" ")[0];
                document.getElementById('edit_last_name').value = data.user[0].full_name.trim().split(" ")[1];
                document.getElementById('edit_email').value = data.user[0].email;
                document.getElementById('edit_role_id').value = data.user[0].role_id;
                document.getElementById('edit_status').value = (data.user[0].status.toLowerCase() === 'active') ? '1' : '0';

                document.getElementById('editUserModal').style.display = 'flex';
            } else {
                alert('User not found.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });

}

function updateUserData(userId) {
    document.getElementById('editUserForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const params = new URLSearchParams();
        for (const pair of formData.entries()) {
            params.append(pair[0], pair[1]);
        }
        // console.log(e);
        params.append('user_id', userId);
        params.append('action', 'update');
        // console.log(params.toString());

        fetch(`${ROOT}/systemadmin/updateuser`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: params.toString()
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('User updated successfully!');
                    closeEditModal();
                    location.reload(); // Refresh the page to show updated data
                } else {
                    alert('Update failed: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating user.');
            });

    });
}

function closeEditModal() {
    const modal = document.getElementById('editUserModal');
    modal.classList.add('closing');

    setTimeout(() => {
        modal.style.display = 'none';
        modal.classList.remove('show', 'closing');
    }, 200);
}

function deleteUser(userId) {
    const modal = document.getElementById('deleteUserModal');
    modal.style.display = 'flex';
    modal.classList.add('show');
    const modalContent = modal.querySelector('.modal-content');
    modalContent.setAttribute('tabindex', '-1');
    modalContent.focus();

    deleteUserData(userId)
}

function deleteUserData(userId) {
    document.getElementById('userDeleteConfirm').addEventListener('click', function (e) {
        // e.preventDefault();


        fetch(`${ROOT}/systemadmin/updateuser`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'user_id=' + encodeURIComponent(userId) + '&action=delete'
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('User deleted successfully.');
                    closeDeleteModal();
                    location.reload(); // Refresh the page to show updated data
                } else {
                    alert('Failed to delete the user.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error deleting user.');
            });
    });
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteUserModal');
    modal.classList.add('closing');

    setTimeout(() => {
        modal.style.display = 'none';
        modal.classList.remove('show', 'closing');
    }, 200);
}

window.editUser = editUser;
window.fetchUserData = fetchUserData;
window.updateUserData = updateUserData;
window.closeEditModal = closeEditModal;
window.deleteUser = deleteUser;
window.deleteUserData = deleteUserData;
window.closeDeleteModal = closeDeleteModal;