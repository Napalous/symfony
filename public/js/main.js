const compteurs = document.getElementById('compteurs');
if(compteurs)
{
    compteurs.addEventListener('click', e =>
    {
        if(e.target.className === 'btn btn-danger delete-compteur')
        {
            if(confirm('Etes vous sûr?'))
            {
                const id = e.target.getAttribute('data-id');
                
                fetch(`/compteur/delete/${id}`, {
                    method: 'DELETE'
                }).then(res => window.location.reload());
            }
        }
    });
}