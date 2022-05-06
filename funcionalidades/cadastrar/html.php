<?php
function sna_cadastrar()
{
?>
    <link rel="stylesheet" href="..\wp-content\plugins\cadastro\funcionalidades\cadastrar\style.css">
    <script type="text/javascript" src="..\wp-content\plugins\cadastro\funcionalidades\cadastrar\script.js"></script>
    <script type="text/javascript" src="..\wp-content\plugins\cadastro\funcionalidades\cadastrar\script.php"></script>
    <table class="wp-list-table widefat striped">
        <thead>
            <tr>
                <th>Cadastro</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>
                    <form method="post" enctype="multipart/form-data">
                        <div style="display: flex; flex-direction: column;">
                            <label>Nome</label>
                            <input type="text" oninput="validar_nome()" required name="nome" id="nome" placeholder="Nome completo" />
                            <label>Email</label>
                            <input type="email" required name="email" placeholder="Email" />
                            <label>CPF</label>
                            <input type="text" required oninput="mascara(this)" name="cpf" placeholder="CPF onze dígitos" />
                            <input type="text" name="experiencia" id="experiencia" style="display:none;" />
                            <table class="wp-list-table widefat striped experiencia">
                                <thead>
                                    <tr>
                                        <th class="table-header">
                                            <a>Experiência profissional</a>
                                            <a onclick="adicionar_experiencia()">Adicionar</a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="experiencias">

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>
                                            <input readonly onclick="salvar_experiencia()" class="button action" name="salvar" value="Salvar" />
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                            <label for="foto">Foto do documento</label>
                            <input type="file" name="foto" />
                            <input type="submit" required class="button action" name="cadastrar" value="Cadastrar" />
                        </div>
                    </form>
                </th>
            </tr>
        </tbody>
    </table>
<?php
}
?>