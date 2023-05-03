<div class="modal fade" tabindex="-1" id="modal-detalheconsulta">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalhes da Consulta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="tipouser" value="<?php echo $user->getTipo(); ?>">
                <input type="hidden" id="idcatual" value="">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputpaciente" type="text" placeholder="Paciente" value="" readonly />
                            <label for="inputpaciente">Paciente</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input class="form-control" id="inputmedico" type="text" placeholder="Médico" value="" readonly />
                            <label for="inputmedico">Médico</label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputcid" type="text" placeholder="CID" value="" readonly />
                            <label for="inputcid">CID</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input class="form-control" id="inputdiagnostico" type="text" placeholder="Diagnóstico" value="" readonly />
                            <label for="inputdiagnostico">Diagnóstico</label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputdata" type="text" placeholder="Data" maxlength="10" onkeypress="mascaraData(this);" value="" readonly />
                            <label for="inputdata">Data</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input class="form-control" id="inputespecialidade" type="text" placeholder="Especialidade" value="" readonly />
                            <label for="inputespecialidade">Especialidade</label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="form-floating mb-3 mb-md-0">
                            <textarea class="form-control" id="txtobs" style="height: 180px;" readonly></textarea>
                            <label for="txtobs">Observações</label>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" id="btnacessarconsulta" onclick="acessarpassada();" class="btn btn-primary">Acessar Consulta</button>
            </div>
        </div>
    </div>
</div>