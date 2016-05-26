<?php $titre= "Liste des controles"
?>
<?php ob_start()
?>
<div id="title">
  <h1>Liste des contrôles</h1>
</div>

<div id="home-top-list">
  <form action="/controle_serveur/index.php/controls/list" method="POST" >
    Trier par:
    <select name="tri">
      <option value="id-croissant" <?php if($tri == 'id-croissant') echo "selected"; ?>> Id croissant </option>
      <option value="id-decroissant" <?php if($tri == 'id-decroissant') echo "selected"; ?>> Id décroissant </option>
      <option value="date-croissante" <?php if($tri == 'date-croissante') echo "selected"; ?>> Date croissante </option>
      <option value="date-decroissante" <?php if($tri == 'date-decroissante') echo "selected"; ?>> Date décroissante </option>
      <option value="type" <?php if($tri == 'type') echo "selected"; ?>> Type </option>
    </select>

    <input type="submit" value="Envoyer" />
  </form>
  <table>

    <tr>
      <th> ID </th>
      <th> Type </th>
      <th> Date </th>
    </tr>

    <?php foreach($controls as $control):
    ?>
    <?php if(!empty($control->server_id)) $server = get_server_by_id($control->server_id)
    ?>

    <a href="/controle_serveur/index.php/controls/show?id=<?php echo $control -> id; ?>" </a>
    <tr class="id">
    <td>
    <a href="/controle_serveur/index.php/controls/show?id=<?php echo $control -> id; ?>"> <?php echo $control -> id; ?> </a>
    </td>
    <td><?php
      if ($control -> type == 'morning') {
        echo "Matin";
      } elseif ($control -> type == 'afternoon') {
        echo "Après-midi";
      } elseif ($control -> type == 'server') {
        echo "Serveur : " . $server -> name;
      } else {
        echo "Tache planifiée";
      }
    ?></td>
    <td><?php echo timestamp_to_date($control -> date_control, "date"); ?></td>

    </tr>
    <?php endforeach ?>
  </table>
  <a href="/controle_serveur/index.php/home" class="button">Ajouter un contrôle</a>
</div>
<?php $content = ob_get_clean(); ?>

<?php
  include 'views/layout.php';
?>