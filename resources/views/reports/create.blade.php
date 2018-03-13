<h1>Create Reports</h1>

@if(session('message'))
    <div>{{ session('message') }}</div>
@endif

<form action="{{ route('reports.store') }}" method="POST">
    @csrf
    
    <div>
        <label>Type</label><br>
        <select name="type">
            <option value="חסר משהו">חסר משהו</option>
            <option value="אחר">אחר</option>
        </select>
    </div>

    <br>

    <div>
        <label>Message</label><br>
        <input type="text" name="message">
    </div>

    <br>

    <div>
        <label>Station</label><br>
        <select name="station">
            <option value="1">kakala</option>
            <option value="3">westron</option>
        </select>
    </div>

    <div>
        <input type="submit" value="Report">
    </div>
</form>
