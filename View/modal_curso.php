<!-- Modal -->
<div class="modal fade " id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoModalLabel">Información</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-content modal">
                    <div id="fotos">
                        <div class="item"><img src="https://via.placeholder.com/150" alt="Imagen 1"></div>
                    </div>

                </div>
            <div class="modal-body ">

                <table class="table mt-3">
                    <tbody>
                        <tr>
                            <th>Título</th>
                            <td id="titulo"></td>
                        </tr>
                        <tr>
                            <th>Entradilla</th>
                            <td id="entradilla"></td>
                        </tr>
                        <tr>
                            <th>Descripción</th>
                            <td id="descripcion"></td>
                        </tr>
                        <tr>
                            <th>Nivel Requerido</th>
                            <td id="nivel_requerido"></td>
                        </tr>
                        <tr>
                            <th>Lugar</th>
                            <td id="lugar"></td>
                        </tr>
                        <tr>
                            <th>Número de Plazas</th>
                            <td id="numero_plazas"></td>
                        </tr>
                        <tr>
                            <th>Duración</th>
                            <td id="duracion"></td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
               <?php
               if (isset($_SESSION) && isset($_SESSION["rol"])){?> <button type="button" class="btn btn-secondary" id="inscribirme"  >Inscribirme</button>
               <?php
               }
               ?>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
</div>
</div>
</div>
</div>