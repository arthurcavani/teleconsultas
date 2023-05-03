<script>
  function mascaraData(val) {
    var pass = val.value;
    var expr = /[0123456789]/;

    for (i = 0; i < pass.length; i++) {
      var lchar = val.value.charAt(i);
      var nchar = val.value.charAt(i + 1);

      if (i == 0) {
        if ((lchar.search(expr) != 0) || (lchar > 3)) {
          val.value = "";
        }

      } else if (i == 1) {

        if (lchar.search(expr) != 0) {
          var tst1 = val.value.substring(0, (i));
          val.value = tst1;
          continue;
        }

        if ((nchar != '/') && (nchar != '')) {
          var tst1 = val.value.substring(0, (i) + 1);

          if (nchar.search(expr) != 0)
            var tst2 = val.value.substring(i + 2, pass.length);
          else
            var tst2 = val.value.substring(i + 1, pass.length);

          val.value = tst1 + '/' + tst2;
        }

      } else if (i == 4) {

        if (lchar.search(expr) != 0) {
          var tst1 = val.value.substring(0, (i));
          val.value = tst1;
          continue;
        }

        if ((nchar != '/') && (nchar != '')) {
          var tst1 = val.value.substring(0, (i) + 1);

          if (nchar.search(expr) != 0)
            var tst2 = val.value.substring(i + 2, pass.length);
          else
            var tst2 = val.value.substring(i + 1, pass.length);

          val.value = tst1 + '/' + tst2;
        }
      }

      if (i >= 6) {
        if (lchar.search(expr) != 0) {
          var tst1 = val.value.substring(0, (i));
          val.value = tst1;
        }
      }
    }

    if (pass.length > 10)
      val.value = val.value.substring(0, 10);
    return true;
  }

  function is_cpf(c) {

    if ((c = c.replace(/[^\d]/g, "")).length != 11)
      return false

    if (c == "00000000000")
      return false;

    if (c == "11111111111")
      return false;

    var r;
    var s = 0;

    for (i = 1; i <= 9; i++)
      s = s + parseInt(c[i - 1]) * (11 - i);

    r = (s * 10) % 11;

    if ((r == 10) || (r == 11))
      r = 0;

    if (r != parseInt(c[9]))
      return false;

    s = 0;

    for (i = 1; i <= 10; i++)
      s = s + parseInt(c[i - 1]) * (12 - i);

    r = (s * 10) % 11;

    if ((r == 10) || (r == 11))
      r = 0;

    if (r != parseInt(c[10]))
      return false;

    return true;
  }


  function fMasc(objeto, mascara) {
    obj = objeto
    masc = mascara
    setTimeout("fMascEx()", 1)
  }

  function fMascEx() {
    obj.value = masc(obj.value)
  }

  function mCPF(cpf) {
    cpf = cpf.replace(/\D/g, "")
    cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2")
    cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2")
    cpf = cpf.replace(/(\d{3})(\d{1,2})$/, "$1-$2")
    return cpf
  }

  $(function() {
    $("input[name='numonly']").on('input', function(e) {
      $(this).val($(this).val().replace(/[^0-9]/g, ''));
    });
  });
</script>

<script>
  function removeOptions(selectElement) {
    var i, L = selectElement.options.length - 1;
    for (i = L; i >= 0; i--) {
      if (i > 0) {
        selectElement.remove(i);
      }
    }
  }

  $('.telefone').maskbrphone({
    useDdd: true, // Define se o usuário deve digitar o DDD  
    useDddParenthesis: true, // Informa se o DDD deve estar entre parênteses  
    dddSeparator: ' ', // Separador entre o DDD e o número do telefone  
    numberSeparator: '-' // Caracter que separa o prefixo e o sufixo do telefone  
  });

  var server = document.domain;
  if (server == 'localhost') {
    var urlsite = 'http://localhost/teleconsultas/';
  } else {
    var urlsite = 'https://' + server + '/teleconsultas/';
  }

  function acessarvideo(ida) {
    $('.loading-spinner').fadeIn();
    $.ajax({

      type: "POST",
      url: urlsite + "conexao/cx_acessavideo.php",
      data: {
        ida: ida
      },
      success: function(resposta) {
        if (parseInt(resposta)) {
          $('.loading-spinner').fadeOut();
          toastr.warning("Erro ao acessar videoconferência");
        } else {
          document.getElementById("framevideo").src = resposta;
          $('.loading-spinner').fadeOut();
          $('#modal-medico').modal({
            backdrop: 'static',
            keyboard: false
          });
          $('#modal-medico').modal('show');
        }
      },
    });
  }

  function acessarpassada() {
    let tipo = document.getElementById("tipouser").value;
    var ida = document.getElementById("idcatual").value;
    if (parseInt(tipo) == 1) {
      window.location.replace(urlsite + 'consulta.php?ida=' + ida);
    } else if (parseInt(tipo) == 2){
      $('.loading-spinner').fadeIn();
      $('#modal-detalheconsulta').modal('hide');
      $.ajax({

        type: "POST",
        url: urlsite + "conexao/cx_acessavideo.php",
        data: {
          ida: ida
        },
        success: function(resposta) {
          if (parseInt(resposta)) {
            $('.loading-spinner').fadeOut();
            toastr.warning("Erro ao acessar videoconferência");
          } else {
            document.getElementById("framevideo").src = resposta;
            $('.loading-spinner').fadeOut();
            $('#modal-paciente').modal({
              backdrop: 'static',
              keyboard: false
            });
            $('#modal-paciente').modal('show');
          }
        },
      });
    }
  }

  $(document).on('click', '.iniciarconsulta', function(e) {
    e.preventDefault();
    var id = $(this).data("id");
    $('.loading-spinner').fadeIn();
    window.location.replace(urlsite + "consulta.php?ida=" + id);
  });

  $(document).on('click', '.p-acessarvideo', function(e) {
    e.preventDefault();
    var id = $(this).data("id");
    $('.loading-spinner').fadeIn();
    $.ajax({
      type: "POST",
      url: urlsite + "conexao/cx_acessavideo.php",
      data: {
        ida: id
      },
      success: function(resposta) {
        if (parseInt(resposta)) {
          $('.loading-spinner').fadeOut();
          toastr.warning("Erro ao acessar videoconferência");
        } else {
          document.getElementById("pframevideo").src = resposta;
          $('.loading-spinner').fadeOut();
          $('#modal-paciente').modal({
            backdrop: 'static',
            keyboard: false
          });
          $('#modal-paciente').modal('show');
        }
      },
    });
  });

  $(document).on('click', '.detalhespaciente', function(e) {
    e.preventDefault();
    $('.loading-spinner').fadeIn();
    var id = $(this).data("id");
    document.getElementById("inputnome").value = "";
    document.getElementById("inputcpf").value = "";
    document.getElementById("inputsexo").value = "";
    document.getElementById("inputdatanasc").value = "";
    document.getElementById("inputemail").value = "";
    document.getElementById("inputtel").value = "";
    document.getElementById("inputprofissao").value = "";
    document.getElementById("inputecivil").value = "";
    document.getElementById("imgperf").src = "";

    $.ajax({

      type: "POST",
      url: urlsite + "conexao/cx_dadospaciente.php",
      data: {
        idu: id
      },
      success: function(response) {
        if (response == 0) {
          location.reload();
          $('.loading-spinner').fadeOut();
        } else {
          var resposta = JSON.parse(response);
          document.getElementById("inputnome").value = resposta.nome;
          document.getElementById("inputcpf").value = resposta.cpf;
          document.getElementById("inputsexo").value = resposta.sexo;
          document.getElementById("inputdatanasc").value = resposta.datanasc;
          document.getElementById("inputemail").value = resposta.email;
          document.getElementById("inputtel").value = resposta.telefone;
          document.getElementById("inputprofissao").value = resposta.profissao;
          document.getElementById("inputecivil").value = resposta.ecivil;
          document.getElementById("btnconsultas").href = 'consultas-paciente.php?p=' + id;
          document.getElementById("imgperf").src = 'imgperfil/' + resposta.imgperfil;
          $('.loading-spinner').fadeOut();
          $('#modal-detalhepaciente').modal('show');
        }
      },
    });

  });

  $(document).on('click', '.detalhesconsulta', function(e) {
    e.preventDefault();
    $('.loading-spinner').fadeIn();
    var id = $(this).data("id");
    document.getElementById("inputpaciente").value = "";
    document.getElementById("inputmedico").value = "";
    document.getElementById("inputcid").value = "";
    document.getElementById("inputdiagnostico").value = "";
    document.getElementById("inputdata").value = "";
    document.getElementById("inputespecialidade").value = "";
    document.getElementById("txtobs").value = "";
    document.getElementById("idcatual").value = id;
    $.ajax({

      type: "POST",
      url: urlsite + "conexao/cx_dadosconsulta.php",
      data: {
        idc: id
      },
      success: function(response) {
        if (response == 0) {
          location.reload();
          $('.loading-spinner').fadeOut();
        } else {
          var resposta = JSON.parse(response);
          //document.getElementById("inputnome").value = resposta.nome;
          document.getElementById("inputpaciente").value = resposta.paciente;
          document.getElementById("inputmedico").value = resposta.medico;
          document.getElementById("inputcid").value = resposta.cid;
          document.getElementById("inputdiagnostico").value = resposta.diagnostico;
          document.getElementById("inputdata").value = resposta.data;
          document.getElementById("inputespecialidade").value = resposta.especialidade;
          document.getElementById("txtobs").value = resposta.obs;

          $('.loading-spinner').fadeOut();
          $('#modal-detalheconsulta').modal('show');
        }
      },
    });

  });

  $(document).on('click', '#btnsalvarc', function(e) {
    e.preventDefault();
    $('.loading-spinner').fadeIn();
    let ida = document.getElementById("idagendamento").value;
    let cid = document.getElementById('cid').value;
    let diagnostico = document.getElementById('diagnostico').value;
    let obs = document.getElementById('observacao').value;
    $.ajax({

      type: "POST",
      url: urlsite + "conexao/cx_salvardadosc.php",
      data: {
        ida: ida,
        cid: cid,
        diagnostico: diagnostico,
        obs: obs
      },
      success: function(response) {
        if (parseInt(response) == 1) {
          location.reload();
        } else {
          toastr.warning('Erro ao salvar');
        }
        $('.loading-spinner').fadeOut();
      },
    });

  });

  $(document).on('click', '#btnfinalizarconsulta', function(e) {
    e.preventDefault();
    $('.loading-spinner').fadeIn();
    let ida = document.getElementById("idagendamento").value;
    $.ajax({

      type: "POST",
      url: urlsite + "conexao/cx_finalizavideo.php",
      data: {
        ida: ida
      },
      success: function(response) {
        if (parseInt(response) == 1) {
          location.reload();
        } else {
          toastr.warning('Erro ao finalizar videoconferência');
        }
        $('.loading-spinner').fadeOut();
      },
    });

  });

  $(document).on('change', '#selectmedico', function(e) {
    e.preventDefault();
    var idm = this.value;
    $('.loading-spinner').fadeIn();
    $.ajax({

      type: "POST",
      url: urlsite + "conexao/cx_diasdisp.php",
      data: {
        idm: idm
      },
      success: function(resposta) {
        removeOptions(document.getElementById('selectdia'));
        var jsonp = JSON.parse(resposta);
        jsonp.forEach(function(data, index) {
          let newOption = new Option(data, data);
          selectdia.add(newOption, undefined);
        });
        $('.loading-spinner').fadeOut();

      },
    });

  });

  $(document).on('change', '#selectdia', function(e) {
    e.preventDefault();
    var dataf = this.value;
    var idm = document.getElementById('selectmedico').value;
    $('.loading-spinner').fadeIn();
    $.ajax({

      type: "POST",
      url: urlsite + "conexao/cx_horariosdisp.php",
      data: {
        idm: idm,
        dataf: dataf
      },
      success: function(resposta) {
        removeOptions(document.getElementById('selecthora'));
        var jsonp = JSON.parse(resposta);
        jsonp.forEach(function(data, index) {
          let newOption = new Option(data, data);
          selecthora.add(newOption, undefined);
        });
        $('.loading-spinner').fadeOut();

      },
    });

  });

  $(document).on('click', '#btnagendar', function(e) {
    e.preventDefault();
    if (document.getElementById('selectmedico').value == 0) {
      toastr.warning('Selecione um médico');
      document.getElementById("selectmedico").focus();
      return false;
    }
    if (document.getElementById('selectdia').value == 0) {
      toastr.warning('Selecione uma data');
      document.getElementById("selectdia").focus();
      return false;
    }
    if (document.getElementById('selecthora').value == 0) {
      toastr.warning('Selecione um horário');
      document.getElementById("selecthora").focus();
      return false;
    }
    $('.loading-spinner').fadeIn();
    let id_medico = document.getElementById('selectmedico').value;
    let dataf = document.getElementById('selectdia').value;
    let horaf = document.getElementById('selecthora').value;
    $.ajax({

      type: "POST",
      url: urlsite + "conexao/cx_novoagendamento.php",
      data: {
        id_medico: id_medico,
        dataf: dataf,
        horaf: horaf
      },
      success: function(response) {
        if (response > 0) {
          $('.loading-spinner').fadeOut();
          window.location.replace(urlsite + "index.php");
        } else {
          $('.loading-spinner').fadeOut();
          toastr.warning('Erro ao solicitar');
        }
      },
    });

  });

  $(document).on('click', '#loginbtn', function(e) {
    e.preventDefault();
    if (document.getElementById('inputEmail').value.trim() == '') {
      toastr.warning('Preencha o e-mail');
      document.getElementById('inputEmail').value = '';
      document.getElementById("inputEmail").focus();
      return false;
    }
    if (document.getElementById('inputPassword').value == '') {
      toastr.warning('Preencha a senha');
      document.getElementById("inputPassword").focus();
      return false;
    }
    $('.loading-spinner').fadeIn();

    let lgn = document.getElementById("inputEmail").value;
    let senha = document.getElementById("inputPassword").value;
    $.ajax({

      type: "POST",
      url: urlsite + "conexao/cx_login.php",
      data: {
        login: lgn,
        senha: senha
      },
      success: function(response) {
        if (response > 0) {
          $('.loading-spinner').fadeOut();
          toastr.success('Bem-vindo(a)!');
          if (response == 1) {
            window.location.replace(urlsite);
          } else {
            window.location.replace(urlsite + "index.php");
          }
        } else {
          $('.loading-spinner').fadeOut();
          toastr.warning('Login ou senha incorretos');
        }
      },
    });

  });


  $(document).on('click', '.sendreset', function(e) {
    e.preventDefault();
    if (document.getElementById('forgot_username').value.trim() == '') {
      toastr.warning('Preencha o e-mail');
      document.getElementById('forgot_username').value = '';
      document.getElementById("forgot_username").focus();
      return false;
    }

    $('.loading-spinner').fadeIn();
    document.getElementById("modaldlg").style.display = 'none';
    //document.getElementById("loading-spinner").style.display = 'block';

    let email = document.getElementById("forgot_username").value;

    $.ajax({

      type: "POST",
      url: urlsite + "conexao_resetpw.php",
      data: {
        email: email
      },

      success: function(response) {
        if (response != 1) {
          $('.loading-spinner').fadeOut();
          document.getElementById("modaldlg").style.display = 'block';
          toastr.warning('E-mail não encontrado');
        } else {
          $('.loading-spinner').fadeOut();
          document.getElementById("modaldlg").style.display = 'block';
          toastr.success('Um e-mail foi enviado para redefinição de senha');
        }
      },
    });

  });

  $(document).on('click', '.aprovarag', function(e) {
    e.preventDefault();
    var id = $(this).data("id");
    $('.loading-spinner').fadeIn();
    $.ajax({

      type: "POST",
      url: urlsite + "conexao/cx_editagendamento.php",
      data: {
        operacao: 1,
        ida: id
      },
      success: function(resposta) {
        if (resposta == "1") {
          document.getElementById("ag_" + id).remove();
          $('.loading-spinner').fadeOut();
          toastr.success('Agendamento aprovado!');
        } else if (resposta == "-1") {
          toastr.warning('Erro');
          $('.loading-spinner').fadeOut();
        }
      },
    });
  });

  $(document).on('click', '#btnalteradisp', function(e) {
    e.preventDefault();
    let seg = 0;
    let ter = 0;
    let qua = 0;
    let qui = 0;
    let sex = 0;
    let sab = 0;
    let dom = 0;
    let duracao = document.getElementById('duracao').value;
    let primeira = document.getElementById('primeirac').value;
    let ultima = document.getElementById('ultimac').value;
    let iniciop = document.getElementById('iniciopausa').value;
    let fimp = document.getElementById('fimpausa').value;

    if (document.getElementById('seg').checked) {
      seg = 1;
    }

    if (document.getElementById('ter').checked) {
      ter = 1;
    }

    if (document.getElementById('qua').checked) {
      qua = 1;
    }

    if (document.getElementById('qui').checked) {
      qui = 1;
    }

    if (document.getElementById('sex').checked) {
      sex = 1;
    }

    if (document.getElementById('sab').checked) {
      sab = 1;
    }

    if (document.getElementById('dom').checked) {
      dom = 1;
    }

    if (seg == 0 && ter == 0 && qua == 0 && qui == 0 && sex == 0 && sab == 0 && dom == 0) {
      toastr.warning('Selecione ao menos um dia na semana');
      return false;
    }

    if (primeira.trim() == '') {
      toastr.warning('Preencha o campo Primeira Consulta');
      document.getElementById("primeirac").focus();
      return false;
    }

    if (ultima.trim() == '') {
      toastr.warning('Preencha o campo Última Consulta');
      document.getElementById("ultimac").focus();
      return false;
    }

    if (iniciop.trim() == '') {
      toastr.warning('Preencha o campo Início Pausa');
      document.getElementById("iniciopausa").focus();
      return false;
    }

    if (fimp.trim() == '') {
      toastr.warning('Preencha o campo Fim Pausa');
      document.getElementById("fimpausa").focus();
      return false;
    }

    if (duracao.trim() == '') {
      toastr.warning('Preencha o campo Duração Consulta com valor em minutos');
      document.getElementById("duracao").focus();
      return false;
    }

    if (!parseInt(duracao)) {
      toastr.warning('Preencha o valor do campo Duração Consulta em minutos');
      document.getElementById('duracao').value = '';
      document.getElementById("duracao").focus();
      return false;
    }

    $('.loading-spinner').fadeIn();
    $.ajax({

      type: "POST",
      url: urlsite + "conexao/cx_updatedisp.php",
      data: {
        seg: seg,
        ter: ter,
        qua: qua,
        qui: qui,
        sex: sex,
        sab: sab,
        dom: dom,
        duracao: duracao,
        primeira: primeira,
        ultima: ultima,
        iniciop: iniciop,
        fimp: fimp
      },
      success: function(resposta) {
        if (resposta == 1) {
          $('.loading-spinner').fadeOut();
          location.reload();
        } else {
          $('.loading-spinner').fadeOut();
          toastr.warning('Erro ao atualizar dados');
        }
      },
    });
  });

  $(document).on('click', '#btnalteradados', function(e) {
    e.preventDefault();

    let nome = document.getElementById('inputnome').value;
    let telefone = document.getElementById('inputtel').value;
    let cpf = document.getElementById('inputcpf').value;
    let novasenha = document.getElementById('inputsenha').value;
    let confirmasenha = document.getElementById('inputconfirmasenha').value;
    let sexo = document.getElementById('selectsexo').value;
    let datanasc = document.getElementById('inputdatanasc').value;
    let email = document.getElementById('inputemail').value;

    let tipouser = document.getElementById('tipouser').value;

    if (tipouser == 2) {
      var estadocivil = document.getElementById('selectecivil').value;
      var profissao = document.getElementById('selectprof').value;
      var nacionalidade = document.getElementById('selectnacionalidade').value;
    } else {
      var estadocivil = 0;
      var profissao = 0;
      var nacionalidade = 0;
    }


    if (!is_cpf(cpf)) {
      toastr.warning('CPF inválido');
      document.getElementById("inputcpf").focus();
      return false;
    }

    if (nome.trim() == '') {
      toastr.warning('Preencha o campo nome');
      document.getElementById("inputnome").focus();
      return false;
    }

    if (email.trim() == '') {
      toastr.warning('Preencha o campo e-mail');
      document.getElementById("inputemail").focus();
      return false;
    }

    if (telefone.trim() == '') {
      toastr.warning('Preencha o campo telefone');
      document.getElementById("inputtel").focus();
      return false;
    }

    const datanascf = datanasc.split("/");
    if (!parseInt(datanascf[0]) || !parseInt(datanascf[1] || !parseInt(datanascf[2]))) {
      toastr.warning('Preencha o campo data de nascimento corretamente');
      document.getElementById('inputdatanasc').value = '';
      document.getElementById("inputdatanasc").focus();
      return false;
    }

    if (novasenha != confirmasenha) {
      toastr.warning('Nova senha não confere com campo de confirmação');
      document.getElementById("inputsenha").focus();
      return false;
    }

    if (novasenha == '') {
      novasenha = 0;
    }

    $('.loading-spinner').fadeIn();
    $.ajax({

      type: "POST",
      url: urlsite + "conexao/cx_updateusuario.php",
      data: {
        nome: nome,
        telefone: telefone,
        cpf: cpf,
        novasenha: novasenha,
        sexo: sexo,
        datanasc: datanasc,
        email: email,
        estadocivil: estadocivil,
        profissao: profissao,
        nacionalidade: nacionalidade
      },
      success: function(resposta) {
        if (resposta == 1) {
          $('.loading-spinner').fadeOut();
          toastr.success('Dados atualizados');
        } else if (resposta == 3) {
          $('.loading-spinner').fadeOut();
          toastr.warning('E-mail já em uso! Restante dos dados foram atualizados');
        } else {
          toastr.warning('Erro ao atualizar dados');
          $('.loading-spinner').fadeOut();
        }
      },
    });
  });

  $(document).on('click', '.cancelarag', function(e) {
    e.preventDefault();
    var id = $(this).data("id");
    bootbox.confirm({
      message: "Tem certeza que deseja cancelar o agendamento?",
      centerVertical: true,
      buttons: {
        cancel: {
          label: 'Não',
          className: 'btn-danger'
        },
        confirm: {
          label: 'Sim',
          className: 'btn-success'
        }
      },
      callback: function(result) {
        if (result == true) {
          $('.loading-spinner').fadeIn();
          $.ajax({

            type: "POST",
            url: urlsite + "conexao/cx_editagendamento.php",
            data: {
              operacao: 0,
              ida: id
            },
            success: function(resposta) {
              if (resposta == "1") {
                $('.loading-spinner').fadeOut();
                location.reload();
              } else {
                toastr.warning('Erro');
                $('.loading-spinner').fadeOut();
              }
            },
          });
        }
      }
    });
    var divsToHide = document.getElementsByClassName("bootbox-close-button");
    for (var i = 0; i < divsToHide.length; i++) {
      divsToHide[i].style.display = "none";
    }
  });

  $(document).on('click', '#btncad', function(e) {
    e.preventDefault();

    if (document.getElementById('inputnome').value.trim() == '') {
      toastr.warning('Preencha o campo nome');
      document.getElementById('inputnome').value = '';
      document.getElementById("inputnome").focus();
      return false;
    }

    let cpf2 = document.getElementById("inputcpf").value;
    if (!is_cpf(cpf2)) {
      toastr.warning('CPF Inválido');
      document.getElementById('inputcpf').value = '';
      document.getElementById("inputcpf").focus();
      return false;
    }

    if (document.getElementById('selectsexo').value == 0) {
      toastr.warning('Selecione o sexo');
      document.getElementById("selectsexo").focus();
      return false;
    }

    let datanasc = document.getElementById('inputdatanasc').value;
    const datanascf = datanasc.split("/");
    if (!parseInt(datanascf[0]) || !parseInt(datanascf[1] || !parseInt(datanascf[2]))) {
      toastr.warning('Preencha o campo data de nascimento corretamente');
      document.getElementById('inputdatanasc').value = '';
      document.getElementById("inputdatanasc").focus();
      return false;
    }

    if (document.getElementById('selectecivil').value == 0) {
      toastr.warning('Selecione o estado civil');
      document.getElementById("selectecivil").focus();
      return false;
    }

    if (document.getElementById('selectnacionalidade').value == 0) {
      toastr.warning('Selecione a nacionalidade');
      document.getElementById("selectnacionalidade").focus();
      return false;
    }

    if (document.getElementById('selectprof').value == 0) {
      toastr.warning('Selecione a profissão');
      document.getElementById("selectprof").focus();
      return false;
    }

    if (document.getElementById('inputtel').value.length < 15) {
      toastr.warning('Preencha o telefone corretamente');
      document.getElementById('inputtel').value = '';
      document.getElementById("inputtel").focus();
      return false;
    }

    if (document.getElementById('inputemail').value.trim() == '') {
      toastr.warning('Preencha o campo e-mail');
      document.getElementById('inputemail').value = '';
      document.getElementById("inputemail").focus();
      return false;
    }

    if (document.getElementById('inputsenha').value.length < 6) {
      toastr.warning('A senha deve possuir ao menos 6 caracteres');
      document.getElementById("inputsenha").focus();
      return false;
    }

    if (document.getElementById('inputsenha').value != document.getElementById('inputconfirmapw').value) {
      toastr.warning('A senha não confere com a confirmação');
      document.getElementById('inputconfirmapw').value = '';
      document.getElementById("inputconfirmapw").focus();
      return false;
    }

    $('.loading-spinner').fadeIn();

    let nome = document.getElementById("inputnome").value;
    let sexo = document.getElementById("selectsexo").value;
    let senha = document.getElementById("inputsenha").value;
    let email = document.getElementById("inputemail").value;
    let estadocivil = document.getElementById("selectecivil").value;
    let profissao = document.getElementById("selectprof").value;
    let nacionalidade = document.getElementById("selectnacionalidade").value;
    let tel = document.getElementById("inputtel").value;

    $.ajax({

      type: "POST",
      url: urlsite + "conexao/cx_cadastropaciente.php",
      data: {
        nome: nome,
        cpf: cpf2,
        senha: senha,
        sexo: sexo,
        datanasc: datanasc,
        email: email,
        estadocivil: estadocivil,
        profissao: profissao,
        nacionalidade: nacionalidade,
        tel: tel
      },
      success: function(response) {
        if (response == 1) {
          window.location.replace(urlsite + "index.php");
        } else if (response == 2) {
          $('.loading-spinner').fadeOut();
          toastr.warning('E-mail já está em uso!');
        } else if (response == 3) {
          $('.loading-spinner').fadeOut();
          toastr.warning('A senha deve possuir ao menos 6 caracteres');
        } else {
          $('.loading-spinner').fadeOut();
          toastr.warning('Erro ao cadastrar, contate o administrador');

        }
      },
    });

  });

  $(document).on('click', '#btncadmed', function(e) {
    e.preventDefault();

    if (document.getElementById('inputnome').value.trim() == '') {
      toastr.warning('Preencha o campo nome');
      document.getElementById('inputnome').value = '';
      document.getElementById("inputnome").focus();
      return false;
    }

    let cpf2 = document.getElementById("inputcpf").value;
    if (!is_cpf(cpf2)) {
      toastr.warning('CPF Inválido');
      document.getElementById('inputcpf').value = '';
      document.getElementById("inputcpf").focus();
      return false;
    }

    if (document.getElementById('selectsexo').value == 0) {
      toastr.warning('Selecione o sexo');
      document.getElementById("selectsexo").focus();
      return false;
    }

    let datanasc = document.getElementById('inputdatanasc').value;
    const datanascf = datanasc.split("/");
    if (!parseInt(datanascf[0]) || !parseInt(datanascf[1] || !parseInt(datanascf[2]))) {
      toastr.warning('Preencha o campo data de nascimento corretamente');
      document.getElementById('inputdatanasc').value = '';
      document.getElementById("inputdatanasc").focus();
      return false;
    }

    if (document.getElementById('inputcrm').value.trim() == '') {
      toastr.warning('Preencha o campo CRM');
      document.getElementById('inputcrm').value = '';
      document.getElementById("inputcrm").focus();
      return false;
    }

    if (document.getElementById('inputespecialidade').value.trim() == '') {
      toastr.warning('Preencha o campo especialidade');
      document.getElementById('inputespecialidade').value = '';
      document.getElementById("inputespecialidade").focus();
      return false;
    }

    if (document.getElementById('inputtel').value.length < 15) {
      toastr.warning('Preencha o telefone corretamente');
      document.getElementById('inputtel').value = '';
      document.getElementById("inputtel").focus();
      return false;
    }

    if (document.getElementById('inputemail').value.trim() == '') {
      toastr.warning('Preencha o campo e-mail');
      document.getElementById('inputemail').value = '';
      document.getElementById("inputemail").focus();
      return false;
    }

    if (document.getElementById('inputsenha').value.length < 6) {
      toastr.warning('A senha deve possuir ao menos 6 caracteres');
      document.getElementById("inputsenha").focus();
      return false;
    }

    if (document.getElementById('inputsenha').value != document.getElementById('inputconfirmapw').value) {
      toastr.warning('A senha não confere com a confirmação');
      document.getElementById('inputconfirmapw').value = '';
      document.getElementById("inputconfirmapw").focus();
      return false;
    }

    $('.loading-spinner').fadeIn();

    let nome = document.getElementById("inputnome").value;
    let sexo = document.getElementById("selectsexo").value;
    let senha = document.getElementById("inputsenha").value;
    let email = document.getElementById("inputemail").value;
    let crm = document.getElementById("inputcrm").value;
    let especialidade = document.getElementById("inputespecialidade").value;
    let tel = document.getElementById("inputtel").value;

    $.ajax({

      type: "POST",
      url: urlsite + "conexao/cx_cadastromedico.php",
      data: {
        nome: nome,
        cpf: cpf2,
        senha: senha,
        sexo: sexo,
        datanasc: datanasc,
        email: email,
        crm: crm,
        especialidade: especialidade,
        tel: tel
      },
      success: function(response) {
        if (response == 1) {
          window.location.replace(urlsite + "index.php");
        } else if (response == 2) {
          $('.loading-spinner').fadeOut();
          toastr.warning('E-mail já está em uso!');
        } else if (response == 3) {
          $('.loading-spinner').fadeOut();
          toastr.warning('A senha deve possuir ao menos 6 caracteres');
        } else {
          $('.loading-spinner').fadeOut();
          toastr.warning('Erro ao cadastrar, contate o administrador');

        }
      },
    });

  });
</script>

<script>
  toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "3000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }
</script>