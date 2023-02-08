
// Criar um evento de quando é alterado o display do loading, fazer a verificação pelo método do Do e verificar o text de eError, corrigir
       
       $(document).ready(function() {
       
       if(document.querySelectorAll("[class='btn btn-primary']")!= null);{
       const btn = document.querySelectorAll("[class='btn btn-primary']");
       for (let i = 0; i < btn.length; i++) {
        btn[i].addEventListener("click", CarregaLoader);
        }}
        
        if(document.querySelectorAll("[data-dismiss='modal']")!= null);{
       const close = document.querySelectorAll("[data-dismiss='modal]");
       for (let i = 0; i < close.length; i++) {
        close[i].addEventListener("click", TiraLoader);
        }}
        //.addEventListener("click", CarregaLoader);
       //document.querySelector("[data-dismiss='modal']").addEventListener("click", TiraLoader);
       
       if(document.querySelector("[onclick='ExcluirVendedor()']")!= null)
       document.querySelector("[onclick='ExcluirVendedor()']").addEventListener("click", CarregaLoader);
       if(document.querySelector("[onclick='ExcluirUsuario()']")!= null)
       document.querySelector("[onclick='ExcluirUsuario()']").addEventListener("click", CarregaLoader);
       if(document.querySelector("[onclick='ExcluirEmpresa()']")!= null)
       document.querySelector("[onclick='ExcluirEmpresa()']").addEventListener("click", CarregaLoader);
       if(document.querySelector("[onclick='ExcluirParceiro()']")!= null)
       document.querySelector("[onclick='ExcluirParceiro()']").addEventListener("click", CarregaLoader);
       if(document.querySelector("[onclick='ExcluirObra()']")!= null)
       document.querySelector("[onclick='ExcluirObra()']").addEventListener("click", CarregaLoader);
       if(document.querySelector("[onclick='GravarObra()']")!= null)
       document.querySelector("[onclick='GravarObra()']").addEventListener("click", CarregaLoader);
       if(document.querySelector("[onclick='GravarPontuacao()']")!= null)
       document.querySelector("[onclick='GravarPontuacao()']").addEventListener("click", CarregaLoader);
       
       if(document.querySelector("[onclick='GravarEmpresa()']")!= null)
       document.querySelector("[onclick='GravarEmpresa()']").addEventListener("click", CarregaLoader);
       //document.querySelector("[onclick='GravarEmpresa()']").addEventListener("mouseup", VerificaLoader);
       
       if(document.querySelector("[onclick='GravarVendedor()']")!= null)
       document.querySelector("[onclick='GravarVendedor()']").addEventListener("click", CarregaLoader);
       if(document.querySelector("[onclick='GravarParceiro()']")!= null)
       document.querySelector("[onclick='GravarParceiro()']").addEventListener("click", CarregaLoader);
       if(document.querySelector("[onclick='Cancelar()']")!= null)
       document.querySelector("[onclick='Cancelar()']").addEventListener("click", TiraLoader);
        if(document.querySelector("[href='usuarios.php']")!= null)
        document.querySelector("[href='usuarios.php']").addEventListener("click", CarregaLoader);
        if(document.querySelector("[href='administrativo.php']")!= null)
        document.querySelector("[href='administrativo.php']").addEventListener("click", CarregaLoader);
        if(document.querySelector("[href='empresas.php']")!= null)
        document.querySelector("[href='empresas.php']").addEventListener("click", CarregaLoader);
        if(document.querySelector("[href='parceiros.php']")!= null)
        document.querySelector("[href='parceiros.php']").addEventListener("click", CarregaLoader);
        if(document.querySelector("[href='pontuacoes.php']")!= null)
        document.querySelector("[href='pontuacoes.php']").addEventListener("click", CarregaLoader);
        if(document.querySelector("[href='promocoes.php']")!= null)
        document.querySelector("[href='promocoes.php']").addEventListener("click", CarregaLoader);
        document.querySelector("[href='sair.php']").addEventListener("click", CarregaLoader);
          });
          
          
          