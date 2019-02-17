const facture = document.getElementById('facture');
if(facture)
{
    facture.addEventListener('click', e =>
    {
        if(e.target.className === 'btn btn-danger delete-fact')
        {
            if(confirm('Etes vous sûr?'))
            {
                const id = e.target.getAttribute('data-id');
                
                fetch(`/facture/delete/${id}`, {
                    method: 'DELETE'
                }).then(res => window.location.reload());
            }
        }
    });
}