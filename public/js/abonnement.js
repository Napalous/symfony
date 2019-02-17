const abonnement = document.getElementById('abonnement');
if(abonnement)
{
    abonnement.addEventListener('click', e =>
    {
        if(e.target.className === 'btn btn-danger delete-abon')
        {
            if(confirm('Etes vous sûr?'))
            {
                const id = e.target.getAttribute('data-id');
                
                fetch(`/abonnement/delete/${id}`, {
                    method: 'DELETE'
                }).then(res => window.location.reload());
            }
        }
    });
}