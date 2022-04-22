class ReservationTurns {

    get table() {
        return document.getElementById( "table_show_turns" );
    }

    turnsHTML = ( idx, turn ) => {
        return `
        <tr data-id="${ turn.ID }" data-booking-id="${ turn.booking_ID }">
            <th scope="row">${ idx + 1 }</th>
            <td class="dir-ltr">${ turn.created_at }</td>
            <td>${ turn.doctor_fullname }</td>
            <td>${ turn.kind_text }</td>
            <td>${ turn.type }</td>
            <td class="dir-ltr">${ turn.date }</td>
            <td class="dir-ltr">${ turn.time }</td>
            <td>${ turn.price } تومان</td>
        </tr>`;
    }

    appendTurnsHTML = () => {
        const table = this.table;

        if ( ! table ) return;

        data_store.reservation_turns.forEach( ( row, index ) => {
            table.querySelector( "tbody" ).insertAdjacentHTML( "beforeend", this.turnsHTML( index, row ) );
        } );
    }


    handleTurnsData = ( response ) => {
        if ( response.data.length < 1 ) return;

        data_store.reservation_turns = response.data;
        
        this.appendTurnsHTML();
    }

    loadturnsData = () => {
        const fetch_data = {
            method: "get",
            data: {}
        };

        ajax_fetch( route.reservation_turns, this.handleTurnsData, fetch_data );
    }

    init = () => {
        this.loadturnsData();
    }

    static run = () => {
        const reservationTurns = new ReservationTurns;

        reservationTurns.init();
    }
}

const init = () => {
    ReservationTurns.run();
}

doc_ready( init );