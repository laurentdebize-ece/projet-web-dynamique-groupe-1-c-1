function loadSection(sectionId) {
    var xhr = $.ajax({
      url: sectionId + '.html',
      type: 'GET',
      success: function(data) {
        $('#content').html(data);
  
        if (sectionId == 'professeur') {
          $('#ajoutProf').submit(function(event) {
            event.preventDefault();
            var nom = $('#nom').val();
            var prenom = $('#prenom').val();
            var matiere = $('#matiere').val();
             
            $.ajax({
              url: 'AdminProfesseur.php',
              type: 'POST',
              data: {
                nom: nom,
                prenom: prenom,
                matiere: matiere,
                action : 'ajout'
              },
              success: function(response) {
                console.log(response);
              },
                
            });
            });
          $('#suppProf').submit(function(event){
            event.preventDefault();
            var nom = $('#nomSupp').val();
            var prenom = $('#prenomSupp').val();
            var email = $('#emailSupp').val();;

            $.ajax({
                url: 'AdminProfesseur.php',
              type: 'POST',
              data: {
                nom: nom,
                prenom: prenom,
                action: 'supp'
              },
              success: function(response) {
                console.log(response);
              },
            })
          });
        }

        if (sectionId == 'etudiant'){
            $('#ajoutEtudiant').submit(function(event) {
                event.preventDefault();
                var nom = $('#nom').val();
                var prenom = $('#prenom').val();
                var matiere = $('#matiere').val();
                 
                $.ajax({
                  url: 'AdminEtudiant.php',
                  type: 'POST',
                  data: {
                    nom: nom,
                    prenom: prenom,
                    action : 'ajout'
                  },
                  success: function(response) {
                    console.log(response);
                  },
                    
                });
                });
        }
      },
      error: function() {
        console.error('Une erreur s\'est produite lors du chargement de la section.');
      }
    });
  }
  