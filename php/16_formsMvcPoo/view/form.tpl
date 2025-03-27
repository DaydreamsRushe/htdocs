  
      <form method="post" name="firstContact" action="" >
            <fieldset class="form-group">
                  <label for="email">Dirección de email</label>
                  <input type="text" class="form-control" id="email" name="email" value="{{#email#}}" >
                  <small id="mostra1" class="text-muted"></small>
            </fieldset>
            <fieldset class="form-group">
                  <label for="asunto">Asunto</label>
                  <input type="text" class="form-control" id="asunto" name="asunto"  value="{{#asunto#}}" >
                  <small id="mostra2" class="text-muted"></small>
            </fieldset>
            <fieldset class="form-group">
                  <label for="contenido">¿Qué te gustaría preguntarnos?</label>
                  <textarea class="form-control" id="contenido" name="contenido" rows="3" minlength="10" maxlength="200">{{#contenido#}}</textarea>
                  <small id="mostra6" class="text-muted"></small>
            </fieldset>
                  <button type="submit" name="enviar" id="enviar" class="btn btn-primary">Enviar</button>
                  <button type="button" name="borrar" id="borrar" class="btn btn-primary">Borrar formulario</button>
      </form>      
    </div>