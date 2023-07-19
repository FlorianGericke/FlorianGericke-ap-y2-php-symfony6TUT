/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';


document.getElementById('table').addEventListener('click', clickEvent => {
    if (clickEvent.target.classList.contains('deleteButton')) {
        if (confirm('Your sure to delete ths Article')) {
            const articleIdToDelete = clickEvent.target.getAttribute('data-id');
            fetch(`/article/delete/${articleIdToDelete}`, {
                method: 'DELETE',
            })
                .then(res => {
                    window.location.reload();
                })
                .catch(err => alert(err));
        }
    }
});