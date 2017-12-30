@extends('layouts.wura')
@section('page_heading','Request for a new Card')
@section('content')

    <div class="row">

        <div class="col-md-12">

            <form class="form-horizontal" method="POST" action="{{ route('cards') }}" enctype="multipart/form-data" >
                {{ csrf_field() }}

                <div style="height: 400px; overflow: auto; text-align:left;" id="Terms" name="Terms">
                    <p>
                        These terms and conditions comprise the agreement between Wurafleet and the Cardholder in
                        connection with the Cardholder’s Visa International Debit Card. These Terms and Conditions
                        therein must be read in conjunction with Wurafleet’s General Account Terms. By accepting and/or
                        using the Debit Card, the Cardholder unconditionally accepts all the following terms and
                        conditions and accepts the onus and liability for ensuring compliance with the relevant foreign
                        exchange laws, and generally the laws of Zimbabwe as applicable.
                        1. Interpretation
                        In these terms and conditions:
                        1.1. “Account” means Wurafleet account held or to be held with Wurafleet in the name of the
                        Cardholder (whether solely or jointly with another person), the number of which is or shall
                        be specified in the application form for the Card
                        1.2. “Account Currency” means the currency in which the Account is denominated.
                        1.3. “Wurafleet” means Standard Chartered Bank Zimbabwe Limited, its successors and
                        assigns.
                        1.4. “Card” means a Standard Chartered Visa International Debit Card issued by Wurafleet at
                        the request and in the name of the person named upon it for use in connection with debit
                        card facilities provided by Wurafleet, including any renewal or replacement Card.
                        1.5. “Cardholder” means the person having power alone to operate the Account in accordance
                        with Wurafleet mandate in respect thereof.
                        1.6. “PIN” means the personal identification number issued to the Cardholder from time to time
                        for use with the Card.
                        1.7. “Transaction” means any cash withdrawal or payment made using the Card, or any refund
                        arising in connection with the use of the Card in any authorised manner for debit or credit to
                        the Account.
                        1.8. “Visa” means Visa International Service Association, a corporation organised and existing
                        under the laws of the State of Delaware, United States of America, having an office and
                        principal place of business at 900 Metro Centre Boulevard, Foster City, CA94404, United
                        States of America or any subsidiary thereof.
                        1.9. “Working days” means Monday to Friday inclusive except public holidays.
                        1.10. References to the singular include the plural and vice versa and references to one gender
                        include references to the other gender. The headings used herein are for ease of reference
                        only.
                        1.11. The Terms form the contract between the Cardholder and Wurafleet. The Cardholder shall
                        be deemed to have unconditionally agreed to and accepted the Terms by signing the Card
                        application form, or acknowledging receipt of the Card in writing, or by signing on the
                        reverse of the Card, or by performing a transaction with the Card or by requesting
                        activation of the Card to Wurafleet’s Call Centre or after 10 days have elapsed since the
                        Card was dispatched to his address on record. The Terms and Conditions will be in
                        addition to and not in derogation of the General Account Terms and Conditions relating to
                        any Account of the Cardholder
                        2. Card facilities
                        2.1. The Cardholder may use the Card to pay for goods or services at retailers or suppliers
                        world-wide who accept the Card by signing a sales voucher and Wurafleet will debit to the
                        Account the amount of any such Transaction authorised in such way.
                        2.2. The Cardholder may use the Card in conjunction with the PIN to withdraw money from
                        automated teller machines which accept the Card when they are operating. The amount of
                        money so withdrawn will be debited to the Account.
                        2.3. The Cardholder may use the Card in conjunction with the PIN to pay for goods and
                        services by using a card operated machine at retailers or suppliers world-wide who offer
                        this facility. Wurafleet will debit to the Account the amount of any Transaction authorised in
                        this way.
                        2.4. The Cardholder may use the Card at any bank which accepts the Card to withdraw money
                        or make payment by signing a voucher, the amount of which will be debited to the Account.
                        2.5. Wurafleet may, at its discretion, make available to the Cardholder more ATMs, POS, and/or
                        other devices through shared networks for the Cardholder’s convenience and use. All fees,
                        charges related to transactions done by the Cardholder at these devices, as determined by
                        us from time to time will be recovered by a debit to the Cardholder’s account. The
                        Cardholder understands and agree that such networks may provide different functionality,
                        service offerings and different charges for different services and/or locations.
                        2.6. Wurafleet, shall, at its sole discretion, at any time, without notice to the Cardholder, be
                        entitled to withdraw, discontinue, cancel, suspend or terminate the facility to use the Card
                        and/or services related to it, at an ATM/other devices within and/or outside Zimbabwe and
                        shall not be liable to the Cardholder for any loss or damage suffered by the Cardholder
                        resulting in any way from such suspension or termination, etc.
                        2.7. If the Cardholder has more than one foreign currency account, Wurafleet shall, at its
                        discretion, be entitled to select any one of the foreign currency accounts to be debited.
                        2.8. The Card is only available to persons over the age of eighteen years and who are of full
                        legal capacity in all other respects.The Card is non-transferable by the Cardholder under
                        any circumstances.
                        2.9. The Cardholder accepts full responsibility for all transactions processed by the use of the
                        Debit Card whether on Automated Teller Machine (ATM), Point-of Sale (POS) Terminal or
                        any other device available or otherwise. Any instruction given by means of the Card shall
                        be irrevocable. The Cardholder shall, in all circumstances, accept full responsibility for the
                        use of the Card, whether or not processed with the Cardholder’s knowledge or his
                        authority, expressed or implied. The Cardholder hereby authorises Wurafleet to debit the
                        Cardholder’s account(s) with the amount(s) of any withdrawal or transfer or carry out any
                        such instructions that may be received by the use of the Card in accordance with the
                        Bank’s record of transactions.
                        2.10. The Cardholder’s obligations with respect to the accounts hereunder are payable solely at
                        Wurafleet at the branch at which the account or deposit was opened by the Cardholder and
                        are subject to the local laws (including, without limitation, any governmental acts, orders,
                        decrees and regulations, including fiscal and exchange control regulations). Wurafleet shall
                        not be liable for non-availability of funds credited to the accounts due to restrictions on
                        convertibility or transferability, requisitions, involuntary transfers, acts of war or civil strife or
                        other similar or other causes beyond Wurafleet’s control, in which circumstance no other
                        branch, subsidiary or affiliate of Wurafleet shall be responsible therefore.
                        3. The Card
                        3.1. The Card belongs to Wurafleet and Wurafleet or any authorised officer, servant, employee,
                        associate or agent of Wurafleet may retain the Card, require the Cardholder to return the
                        Card or suspend the use of the Card at any time in its absolute discretion and Wurafleet
                        shall not be liable for any loss suffered by the Cardholder as a result thereof.
                        3.2. The Card is only valid for the period shown on it and must not be used outside that period
                        or if Wurafleet has required by notice in writing to the Cardholder that it be returned to the
                        Bank. When the period of validity of a Card expires it must be destroyed by cutting it in half
                        through the magnetic strip.
                        3.3. The Cardholder must take all reasonable precautions to prevent unauthorised use of the
                        Card, including, not allowing anyone else to use the Card.
                        3.4. If the Card is lost or stolen the Cardholder shall immediately notify Wurafleet by telephoning
                        the number(s) from time to time notified to the Cardholder and the Cardholder must, in
                        addition, immediately notify relevant law enforcement agencies. The Cardholder must
                        confirm the loss of the Card by notice in writing to Wurafleet within seven days of having
                        notified Wurafleet by telephone.
                        3.5. The Cardholder must co-operate with any officers, employees or agents of Wurafleet and/or
                        law enforcement agencies in any efforts to recover the Card if it is lost or stolen.
                        3.6. If the Card is found after Wurafleet has been given notice of its loss or theft the Cardholder
                        must not use it again. The Card must be cut in half through the magnetic strip and returned
                        to Wurafleet immediately.
                        3.7. Features on a Card: Wurafleet may from time to time, at its discretion, tie-up with various
                        agencies to offer features on Debit Cards. All these features would be on a best efforts
                        basis only, and Wurafleet does not guarantee or warrant the efficacy, efficiency, usefulness
                        of any of the products or services offered by any service providers/
                        merchants/outlets/agencies. Disputes (if any) will be taken up with the merchant/ agency,
                        etc. directly, without involving Wurafleet.
                        4. The PIN
                        4.1. Wurafleet will initially allocate a Personal Identification Number (PIN) to the Cardholder.
                        The Cardholder may select the Cardholder’s own PIN (any 4-digit number) if the
                        Cardholder would like to change it, depending on the availability of the proposed number.
                        4.2. The security of the PIN is very important and the Cardholder shall not disclose the
                        Cardholder’s PIN to anyone. If the Cardholder fail to observe any of the security
                        requirements, the Cardholder may, at the Cardholder’s sole risk as to the consequences,
                        incur liability for unauthorised use.
                        4.3. If the Cardholder chooses his own PIN, he should not select a PIN that is easily identified
                        or identifiable with him , e.g. birth date, car registration number, or repeated numbers etc.
                        The Cardholder should not write or indicate the PIN on the Card or on any other item the
                        Cardholder carry or store.
                        5. Usage Guidelines
                        5.1. International Usage and Government of Zimbabwe/Reserve Bank of Zimbabwe (RBZ)
                        requirements: The Cardholder confirms that he will use the International Debit Cards only
                        for permissible current account transactions in terms of the Zimbabwe Exchange Control
                        Regulations, Reserve Bank of Zimbabwe Directives and other applicable local laws,
                        regulations and directives as amended from time to time.
                        5.2. The Cardholder shall ensure adherence to all requirements of the Exchange Control
                        Regulations with regard to foreign exchange entitlements as stipulated by the RBZ from
                        time to time. Usage of the card outside Zimbabwe will be made strictly in accordance with
                        the foreign exchange laws and regulations of Zimbabwe including the Exchange Control
                        Regulations of the Reserve Bank of Zimbabwe. The Cardholder shall be solely and
                        completely liable and responsible for any non-compliance with those laws, regulations
                        and/or notifications. The onus of ensuring compliance with the aforementioned provisions
                        rests solely with the Cardholder. The Cardholder accepts full responsibility for wrongful use
                        and use in contravention of these Rules and Regulations and undertakes to indemnify the
                        Bank to make good any loss, damage, interest, conversion, any other financial charges that
                        Wurafleet may incur and/or suffer on account thereof.
                        5.3. The Cardholder will be responsible for all facilities granted by Wurafleet and for all related
                        charges and shall act in good faith in relation to all dealings with the Card and Wurafleet.
                        .Wurafleet reserves the right to change the types of Transactions supported without any
                        notice to the Cardholder
                        5.4. The Cardholder is not authorised to enter into Transactions using the Card to a value in
                        excess of the credit balance (if any) of the Account from time to time. The Account will be
                        charged interest by Wurafleet at the relevant interest rate of Wurafleet in respect of
                        unauthorised overdrafts on the Account unless otherwise agreed and Wurafleet’s usual fees
                        for unauthorised overdrafts may also be charged to the Account.
                        5.5. The Cardholder shall at all times ensure that the Card is kept at a safe place and shall
                        under no circumstances whatsoever allow the Card to be used by any other individual.
                        5.6. The total amount of any Transactions carried out in any one day shall be limited to such
                        amounts and by such other conditions as shall be notified in writing to the Cardholder by
                        Wurafleet from time to time with effect from the date of such notice.
                        5.7. When the Card is used to effect a Transaction through Visa (whether with a retailer or
                        supplier, a bank or from a card operated cash machine) in a currency other than the
                        Account Currency, Visa will convert the amount of the Transaction into the Account
                        Currency at the applicable exchange rate on the day upon which it receives notification of
                        the Transaction.
                        5.8. The card may not be used as payment for an illegal purchase.
                        5.9. The Card may not be used for any Mail Order/Phone Order purchases and any such usage
                        will be considered as unauthorised.
                        5.10. The Card is for Electronic use only and will be acceptable only at Merchant Establishments,
                        which have a Point-or-Sale (POS) terminal or similar terminal that accepts the Cards. Any
                        usage of the Card other than electronic use will be considered as unauthorised.
                        5.11. The Card will be honoured only when it carries the signature of the Cardholder. The Card is
                        operable with the help of the Cardholder’s signature or the PIN at POS terminals installed
                        at Merchant locations depending on the functionality of the POS terminal.
                        5.12. Each Transaction is deemed authorised and completed once the terminal generates a
                        Sales Slip. The amount of the transaction is debited immediately from the primary account
                        linked to the Card. The Cardholder should ensure that the Card is used only once at the
                        Merchant location for every transaction
                        5.13. In the event of an account being overdrawn, Wurafleet reserves the right to set off
                        overdrawn amounts against any credit lying in any of the Cardholder’s other accounts held
                        jointly or singly, without giving any notice. Nothing in these terms and conditions shall affect
                        Wurafleet’s right to set-off, transfer and apply monies at law or pursuant to any other
                        agreement from time to time subsisting between Wurafleet and the Cardholder.
                        5.14. Wurafleet shall not in any way be responsible for merchandise, merchandise warranty or
                        services purchased, or availed of by the Cardholder from Merchant Establishments,
                        including on account of delay in delivery, non-delivery, non receipt of goods or receipt of
                        defective goods by the Cardholder. The Card is purely a facility to the Cardholder to
                        purchase goods and/or avail of services, Wurafleet holds out no warranty or makes no
                        representation about quality, delivery or otherwise of the merchandise. Any dispute or claim
                        regarding the merchandise must be resolved by the Cardholder with the Merchant
                        Establishment. The existence of the claim or dispute shall not relieve the Cardholder of
                        his/her obligation to pay all the Charges due to Wurafleet and the Cardholder agrees to pay
                        promptly such charges. The Cardholder shall be responsible for regularly reviewing these
                        Terms and Conditions including amendments thereto as may be advised from time to time
                        and shall be deemed to have accepted any amended Terms by continuing to use the Card.
                        6. Charges
                        6.1. In addition to the amount of all Transactions, certain charges will be debited to the Account
                        as provided for herein.
                        6.2. Wurafleet shall charge an annual fee to each Cardholder in accordance with Wurafleet’s
                        schedule of fees from time to time in force. The annual fees for the Card will be debited to
                        the Account linked with the Card on application/renewal at Wurafleet’s prevailing rate. The
                        fees are not refundable.
                        6.3. There will be separate service charges levied for such facilities as may be announced by
                        Wurafleet from time to time and deducted from the Cardholder’s Account.
                        6.4. In the case of transactions entered into by the Cardholder through the Card, the equivalent
                        in the currency in which the Cardholder’s Account is held, along with processing charges, 
                        Visa International Debit Card – Terms and Conditions
                        conversion charges, fees if any and other service charges for such transactions shall be
                        debited to the Cardholder’s Account held at Wurafleet. The Cardholder authorises Wurafleet
                        to recover all charges related to the Card as determined by Wurafleet from time to time by
                        debiting the Client’s Account(s).
                        6.5. Wurafleet accepts no responsibility for any surcharge levied by any Merchant
                        Establishment and debited to the Account linked with the Card with the Transaction
                        amount. Any charge or other payment requisition received from a Merchant Establishment
                        by Wurafleet for payment shall be conclusive proof that the charge recorded on such
                        requisition was properly incurred at the Merchant Establishment for the amount and by the
                        Cardholder using the Card referred to in that charge or other requisition, except where the
                        Card has been lost, stolen or fraudulently misused, the burden of proof for which shall be
                        on the Cardholder.
                        6.6. Any government charges, duty or debits, or tax payable as a result of the use of the Card
                        shall be the Cardholder’s responsibility and if imposed upon Wurafleet (either directly or
                        indirectly), Wurafleet shall debit such charges, duty or tax against the Account. In addition,
                        operators of Shared Networks may impose an additional charge for each use of their ATM/
                        POS Terminal/other device, and any such charge along with other applicable fees/charges
                        will be deducted from the Cardholder’s Account.
                        6.7. Where the Account does not have sufficient funds to deduct such fees, Wurafleet reserves
                        the right to deny any further Transactions. In case of Accounts classified as overdrawn
                        Accounts, the Cardholder will have to rectify the Account balance position immediately. In
                        every such situation where the Account becomes overdrawn, a flat charge could be levied
                        in addition to the interest to be charged on the debit balance in the Account. This charge
                        will be determined by Wurafleet and will be announced from time to time. In the event of an
                        Account being overdrawn due to Card Transactions, Wurafleet reserves the right to setoff
                        this amount against any credit lying from any of the Cardholder’s other Accounts held jointly
                        or singly without giving any notice.
                        6.8. Wurafleet reserves the right to deduct from the Cardholder’s Account a reasonable service
                        charge and any expenses it incurs, including without limitation reasonable legal fees, due to
                        legal action involving the Cardholder’s Card.
                        6.9. Nothing in the Terms shall affect Wurafleet’s right of setoff, transfer and application of
                        monies at law or pursuant to any other agreement from time to time subsisting between the
                        Bank and Cardholder. The Cardholder also authorizes Wurafleet to deduct from his
                        Account, and indemnifies Wurafleet against any expenses it may incur in collecting money
                        owed to it by the Cardholder in connection with the Card. (including without limitation
                        reasonable legal fees).
                        6.10. Wurafleet may, at its discretion levy penal charges for non- maintenance of the minimum
                        balance. In addition to the minimum balance stipulation Wurafleet may levy service and
                        other charges for use of the Card, which will be notified to the Cardholder from time to time.
                        7. Unauthorised transactions
                        7.1 The Cardholder will be solely liable for all unauthorised acts and transactions.
                        8. Disclosure of Information
                        8.1. Wurafleet reserves the right, and the Cardholder hereby agree to Wurafleet having the right,
                        to disclose to and share with and receive from other institutions, credit referencing bureaus,
                        agencies, statutory, executive,judicial and regulatory authorities, whether on request or
                        under an order therefrom, and on such terms and conditions as may be deemed fit by the
                        Bank or otherwise, such information concerning the Cardholder’s account as may be
                        necessary or appropriate including in connection with its participation in any Electronic
                        Funds Transfer Network.
                        8.2. The use of the Debit Card at an ATM/POS/other devices shall constitute the Cardholder’s
                        express consent:
                        - To the collection, storage, communication and processing of personally identifying and
                        account balance information by any means necessary for us to maintain appropriate
                        transaction and account records.
                        - To the release and transmission to participants and processors in the Standard chartered
                        bank ATM network/other networks of details of the Cardholder’s account and transaction
                        information and other data necessary to enable the Cardholder’s Card to be used at an
                        ATM/other device.
                        - To the retention of such information and data by the said participants and processors in
                        the Standard chartered bank/other networks.
                        - To the compliance by the said participants and processors in the Standard Chartered bank
                        ATM network/other networks with laws and regulations governing disclosure of information
                        to which such participants and processors are subject and
                        - To disclosure of information to third parties about the Cardholder’s Standard chartered
                        bank account or the transactions done through the use of the Cardholder’s Card where it so
                        necessary for completing transactions and/or when necessary to comply with law or
                        government agency or court orders or legal proceedings and/or when necessary to resolve
                        errors or questions the Cardholder may raise and/or in order to satisfy our internal data
                        processing requirements.
                        11.3 The Cardholder hereby expressly authorises Wurafleet to disclose at any time and for any
                        purpose, any information whatsoever relating to the Cardholder’s personal particulars,
                        accounts, transactions, or dealings with Wurafleet, to the head office or any other branches,
                        subsidiaries, or associated or affiliated corporations or entities of Wurafleet wherever
                        located, any government or regulatory agencies or authorities in Zimbabwe or elsewhere,
                        any agents or contractors which have entered into an agreement to perform any service(s)
                        for Wurafleet’s benefit, and any other person(s) whatsoever where the disclosure is required
                        by law or otherwise to whom Wurafleet deems fit to make such disclosure.
                        11.4 The Cardholder agrees to provide Wurafleet information Wurafleet would require from the
                        Cardholder under law or regulation, or any other appropriate information we reasonably
                        request from time to time.
                        11.5 Wurafleet may disclose information about the Cardholder and the Account if Wurafleet
                        thinks it will help avoid or recover any loss to the Cardholder or Wurafleet resulting from the
                        loss, theft, misuse or unauthorised use of the Card.
                        9. Exclusion from Liability
                        In consideration of Bank providing the Cardholder with the facility of Card, the Cardholder
                        hereby agrees to indemnify and keep Wurafleet indemnified from and against all actions,
                        claims, demands, proceedings, losses, damages, personal injury, costs, charges and
                        expenses whatsoever which Wurafleet may at any time incur, sustain, suffer or be put to as
                        a consequence of or by reason of or arising out of providing the Cardholder the said facility
                        of the Card or by reason of Wurafleet’s acting in good faith and taking or refusing to take or
                        omitting to take action on the Cardholder’s instructions, and in particular arising directly or
                        indirectly out of the negligence, mistake or misconduct of the Cardholder; breach or
                        noncompliance of the rules/ Terms and Conditions relating to the Card and the Account
                        and/or fraud or dishonesty relating to any Transaction by the Cardholder or his employee or
                        agents. The Cardholder shall indemnify and hold harmless Wurafleet from any and all
                        consequences arising from the Cardholder not complying with the Exchange Control
                        Regulations, breach of the Exchange Control Act or any other statutory instrument, The
                        Cardholder agrees to indemnify Wurafleet for any machine/ mechanical error/failure. The
                        Cardholder shall also indemnify Wurafleet fully against any loss on account of misplacement
                        by the courier or loss-in-transit of the Card/PIN. Without prejudice to the foregoing, the
                        Bank shall be under no liability whatsoever to the Cardholder in respect of any loss or
                        damage arising directly or indirectly out of:
                        i. Any defect in quality of goods or services supplied.
                        ii. The refusal of any person to honor to accept a Card.
                        iii. The malfunction of any computer terminal.
                        iv. Effecting Transaction instructions other than by a Cardholder.
                        v. The exercise by Wurafleet of its right to demand and procure the surrender of the
                        Card prior to the expiry date exposed on its face, whether such demand and
                        surrender is made and/or procured by Wurafleet or by any person or computer
                        terminal.
                        vi. The exercise by Wurafleet of its right to terminate any Card
                        vii. Any injury to the credit, character and reputation of the Cardholder alleged to have
                        been caused by the re-possession of the Card and/or, any request for its return or
                        the refusal of any Merchant Establishment to honor or accept the Card.
                        ix. Any misstatement, misrepresentation, error or omission in any details disclosed by
                        Wurafleet except as otherwise required by law, if Wurafleet receives any process,
                        summons, order, injunction, execution distrait, levy lien, information or notice which
                        Wurafleet in good faith believes/ calls into question the Cardholder’s ability, or the
                        ability of someone purporting to be authorised by the Cardholder, to transact on the
                        Card, Wurafleet may, at its option and without liability to the Cardholder or such other
                        person, decline to allow the Cardholder to obtain any portion of his funds, or may
                        pay such funds over to an appropriate authority and take any other steps required by
                        applicable law.
                        x. Any statement made by any person requesting the return of the Card or any act
                        performed by any person in conjunction ;
                        xi. In the event a demand or claim for settlement of outstanding dues from the
                        Cardholder is made, either by Wurafleet or any person acting on behalf of Wurafleet,
                        the Cardholder agrees and acknowledges that such demand or claim shall not
                        amount to be an act of defamation or an act prejudicial to or reflecting upon the
                        character of the Cardholder, in any manner.
                        10. Disputes
                        10.1. In case the Cardholder has any dispute in respect of any charge indicated in the Account
                        Statement, the Cardholder shall advise details to Wurafleet within 15 days of the Account
                        Statement date failing which it will be construed that all charges are acceptable and in
                        order.
                        10.2. Wurafleet accepts no responsibility for refusal by any Merchant Establishment to accept
                        and/or honour the Card. In case of dispute pertaining to a Transaction with a Merchant
                        Establishment a charge/sales slip with the signature of the Cardholder together with the
                        Card number noted thereon shall be conclusive evidence as between Wurafleet and the
                        Cardholder as to the extent of liability incurred by the Cardholder and Wurafleet shall not be
                        required to ensure that the Cardholder has duly received the goods purchased/to be
                        purchased or has duly received the service availed/to be availed to the Cardholder’s
                        satisfaction.
                        10.3. Any dispute in respect of a Shared Network ATM Transaction will be resolved as per VISA
                        Regulations. Wurafleet does not accept responsibility for any dealings the Cardholder may
                        have with Shared Networks Should the Cardholder have any complaints concerning any
                        Shared Network ATM, the matter should be resolved by the Cardholder with the Shared
                        Network, and failure to do so will not relieve him from any obligations to Wurafleet.
                        However, the Cardholder should notify Wurafleet of the complaint immediately.
                        10.4. If a retailer or supplier makes a refund by means of a Transaction Wurafleet will credit the
                        Account when it receives the retailer or supplier’s proper instructions and the funds in
                        respect of such refund, provided that Wurafleet will not be responsible for any loss resulting
                        from any delay in receiving such instructions and funds.
                        11. Termination
                        11.1. The Cardholder may discontinue/ terminate the Card anytime by a written notice to the
                        Bank accompanied by the return of the Card cut into two pieces diagonally. The Cardholder
                        shall be liable for all charges incurred, up to the receipt of the written notice duly
                        acknowledged by Wurafleet.
                        11.2. Wurafleet may at any time, with or without notice, as to the circumstances in Wurafleet’s
                        absolute discretion require, terminate the Card.
                        11.3. The agreement comprised in these terms and conditions, shall be deemed to remain in full
                        force and effect if and in so far as any Transaction is completed but not debited to the
                        Account prior to termination thereof.
                        11.4. Termination of the agreement comprised in these terms and conditions shall not prejudice
                        any liability in respect of things done or omitted to be done prior to termination thereof.
                        12. General
                        11.1 Wurafleet will issue a Card only if the Cardholder has completed an application form and it
                        has been accepted by Wurafleet, or if Wurafleet at its discretion is replacing or renewing a
                        Card.
                        11.2 If Wurafleet is asked to authorise a Transaction, Wurafleet may take into consideration any
                        other Transactions which have been authorised but which have not been debited to the
                        Account (and any other transactional activities upon the Account) the limits and if Wurafleet
                        determines that there are or will be insufficient available funds in the Account to pay the
                        amount that would be due in respect of such Transaction, Wurafleet may in its own absolute
                        discretion refuse to authorise such Transaction, in which event such Transaction will not be
                        debited to the Account. Wurafleet shall not be liable for any loss resulting from any such
                        refusal to authorise any Transaction.
                        12.1. In the event that there are insufficient available funds in the Account to pay any Transaction
                        or other amount payable from the Account, including any interest, fees, charges or other
                        payments due to Wurafleet, Wurafleet may in its own absolute discretion (and without any
                        obligation to do so) transfer or arrange the transfer of sufficient funds from any other
                        account held by the Cardholder with Wurafleet to the Account.
                        12.2. The Cardholder shall notify Wurafleet if the Cardholder’s address is changed, as soon as
                        possible.
                        12.3. A Transaction cannot be cancelled by the Cardholder after it has been completed.
                        12.4. If the Card is to be issued to a corporate entity Wurafleet reserves the right to vary and/or
                        add to these terms and conditions as it may in its discretion consider appropriate.
                        12.5. Wurafleet shall have the absolute discretion to amend or supplement any of the Terms,
                        features and benefits offered on the Card including, without limitation to, changes which
                        affect interest charges or rates and methods of calculation at any time . The Cardholder
                        shall be liable for all charges incurred and all other obligations under these revised Terms
                        until the all amounts under the Card are repaid in full. Wurafleet may communicate the
                        amended Terms in any manner as decided by Wurafleet.
                        12.6. These terms and conditions and Wurafleeting practices and charges relating thereto may be
                        changed by Wurafleet at any time by notice thereof to the Cardholder. Any such changes
                        will be effective from the date of the notice or such later date as may be specified therein.
                        13. Governing Law and Jurisdiction
                        These Terms Conditions shall be governed by and construed in accordance with the law of
                        Zimbabwe and the Cardholder irrevocably agrees to submit to the exclusive jurisdiction of
                        the courts of Zimbabwe in connection herewith
                    </p>
                </div>           

                <br />
                <button type="submit" value="Accept" id="ContinueButton" name="ContinueButton" class="btn btn-primary pull-right"> Accept! </button>
            </form>
        </div>

    </div>

@endsection