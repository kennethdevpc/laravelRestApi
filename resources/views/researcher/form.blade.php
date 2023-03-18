<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

<div class="box box-info padding-1">
    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" id="updateApi"name="updateApi" value="updateApi">
        <label class="form-check-label" for="flexSwitchCheckDefault">Update from API</label>
    </div>
    <div class="box-body" name="fillForm"  id="fillForm">

        <div class="form-group" >
            <input class="form-control" type="text" name="orcid" value={{$researcher->orcid}} readonly>
        </div>
        <div class="form-group" hidden="">
            {{ Form::label('nombre') }}
            {{ Form::text('nombre', $researcher->nombre, ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre','value' => 'readonly']), }}
            {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('name') }}
            {{ Form::text('name', $researcher->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Name']) }}
            {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('familyName') }}
            {{ Form::text('familyName', $researcher->familyName, ['class' => 'form-control' . ($errors->has('familyName') ? ' is-invalid' : ''), 'placeholder' => 'FamilyName']) }}
            {!! $errors->first('familyName', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="form-group">
            {{ Form::label('email') }}
            {{ Form::text('email', $researcher->email, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'placeholder' => 'email']) }}
            {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        {{ Form::label('keywords') }}

        <div class="form-group  border-indigo-500/50"
             style="border-style: solid; border-color: {{ 1 === 1 ? 'gray' : 'green' }};background-color: {{1 === 1 ? '#FFEFD5' : '#FFFFFF' }} ">
            <select name="keywords[]" id="keywords" class="form-control " data-style="btn-primary"
                    title="selet the keywords you want to keep, use CTRL key for multiple selection!"
                    multiple="multiple">
                @foreach ($researcher->keywords as $researchery)
                    <option value="  {{ $researchery }}">  {{ $researchery }}</option>

                @endforeach


            </select>


            <br>

            <div id="table" class="form-group d-flex flex-row bd-highlight mb-3">
            </div>
            <label for="entradax">Add keyword</label>
            <input type="text" name="newKeyword" id="newKeyword">
            <button type="button" name="adde" id="adde" class="btn btn-success">Add other Keyword</button>

        </div>

        <br>


    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>

</div>

<script>
    var i = 0
    let newKeyword
    let newKeywords = [];
    updateApiValue=0
    $('#updateApi').on('change', function (e) {
        if(updateApiValue==0){
            document.getElementById("updateApi").value=1
            document.getElementById("fillForm").setAttribute('hidden', '')

            updateApiValue=1;

        }else{
            if(updateApiValue==1){
                document.getElementById("updateApi").value=0

                updateApiValue=0
                document.getElementById("fillForm").removeAttribute('hidden')


            }
        }

        //console.log('fupdate api change', $(this));
        updateApiValue=document.getElementById("updateApi").value
        console.log('fupdate api change valor', updateApiValue);

        //newKeyword = $(this).val();
        //$(this).val('');
    });
    $('#newKeyword').on('change', function (e) {
        console.log('forma1 keyword', $(this).val());
        newKeyword = $(this).val();
        $(this).val('');
    });


    $('#adde').click(function (e) {
        if (newKeyword == undefined || newKeyword == '') {
            alert("Insert the new Keyword")
        } else {
            newKeywords.push(newKeyword)
            if (newKeywords.length > 0) {
                // datodeboton = $('#addKeywords')[0].removeAttribute('hidden')
            }
            $('#table').append(
                `<tr>
                <td>
                    <label type="text" name="` + newKeyword + `" value="` + newKeyword + `"  class="form-control">
                    ` + newKeyword + `
                    <button type="button" class="btn btn-danger remove-table-row">
                    x
                    </button>
                    </label>
                </td>
            </tr>`);

            $('#keywords').append(
                `
                    <option value="` + newKeyword + `" name="` + newKeyword + `">  ` + newKeyword + `  </option>
                `
            )
        }
    })

    $(document).on('click', '.remove-table-row', function () {
        labelX = $(this).parents('label')
        namel = labelX[0].getAttribute('value')
        labelX.remove();
        optionL1b = $(`#keywords option[value=${namel}]`).remove()

        alert("eliminando", $(this).val());
        newKeywords = newKeywords.filter((e) => e !== namel);
    })


</script>







