//
//  CompetitionsDetailViewController.m
//  MatchTrackerApp
//
//  Created by Jesse on 11/01/13.
//  Copyright (c) 2013 Jesse. All rights reserved.
//

#import "CompetitionsDetailViewController.h"
#import "TeamsViewController.h"

@interface CompetitionsDetailViewController ()

@end

@implementation CompetitionsDetailViewController
@synthesize competition;

- (id)initWithStyle:(UITableViewStyle)style
{
    self = [super initWithStyle:style];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];

    // Uncomment the following line to preserve selection between presentations.
    // self.clearsSelectionOnViewWillAppear = NO;
 
    // Uncomment the following line to display an Edit button in the navigation bar for this view controller.
    // self.navigationItem.rightBarButtonItem = self.editButtonItem;
    
    // Set the navigation title
    self.navigationItem.title = competition.name;
    
    // Fill the form with data
    self.lblName.text = competition.name;
    self.txtDescription.text = competition.description;
    self.lblSportType.text = competition.sportType;
    self.lblPlace.text = [competition.place length] == 0 ? @"Locatie voorzien door team" : competition.place;

    NSDateFormatter *dateFormatter = [[NSDateFormatter alloc] init];
    [dateFormatter setTimeStyle:NSDateFormatterNoStyle];
    [dateFormatter setDateStyle:NSDateFormatterMediumStyle];
    NSLocale *nlLocale = [[NSLocale alloc] initWithLocaleIdentifier:@"nl_NL"];
    [dateFormatter setLocale:nlLocale];
    self.lblDate.text = [NSString stringWithFormat:@"%@ - %@",[dateFormatter stringFromDate:competition.startdate],[dateFormatter stringFromDate:competition.startdate]];
    
    self.lblScores.text = [NSString stringWithFormat:@"Er zijn %d scores", 0];
    self.lblTeams.text = [NSString stringWithFormat:@"Er zijn %d teams", [competition.teams count]];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

#pragma mark - Table view data source

//- (NSInteger)numberOfSectionsInTableView:(UITableView *)tableView
//{
//#warning Potentially incomplete method implementation.
//    // Return the number of sections.
//    //return 0;
//}
//
//- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
//{
//#warning Incomplete method implementation.
//    // Return the number of rows in the section.
//    //return 0;
//}
//
//- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
//{
//    static NSString *CellIdentifier = @"Cell";
//    UITableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:CellIdentifier forIndexPath:indexPath];
//    
//    // Configure the cell...
//    
//    return cell;
//}

/*
// Override to support conditional editing of the table view.
- (BOOL)tableView:(UITableView *)tableView canEditRowAtIndexPath:(NSIndexPath *)indexPath
{
    // Return NO if you do not want the specified item to be editable.
    return YES;
}
*/

/*
// Override to support editing the table view.
- (void)tableView:(UITableView *)tableView commitEditingStyle:(UITableViewCellEditingStyle)editingStyle forRowAtIndexPath:(NSIndexPath *)indexPath
{
    if (editingStyle == UITableViewCellEditingStyleDelete) {
        // Delete the row from the data source
        [tableView deleteRowsAtIndexPaths:@[indexPath] withRowAnimation:UITableViewRowAnimationFade];
    }   
    else if (editingStyle == UITableViewCellEditingStyleInsert) {
        // Create a new instance of the appropriate class, insert it into the array, and add a new row to the table view
    }   
}
*/

/*
// Override to support rearranging the table view.
- (void)tableView:(UITableView *)tableView moveRowAtIndexPath:(NSIndexPath *)fromIndexPath toIndexPath:(NSIndexPath *)toIndexPath
{
}
*/

/*
// Override to support conditional rearranging of the table view.
- (BOOL)tableView:(UITableView *)tableView canMoveRowAtIndexPath:(NSIndexPath *)indexPath
{
    // Return NO if you do not want the item to be re-orderable.
    return YES;
}
*/

#pragma mark - Table view delegate

- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath
{
    // Navigation logic may go here. Create and push another view controller.
    /*
     <#DetailViewController#> *detailViewController = [[<#DetailViewController#> alloc] initWithNibName:@"<#Nib name#>" bundle:nil];
     // ...
     // Pass the selected object to the new view controller.
     [self.navigationController pushViewController:detailViewController animated:YES];
     */
}

-(void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender{
    if([[segue identifier] isEqualToString:@"AllTeamsSegue"]){
        TeamsViewController *vc = [segue destinationViewController];
        vc.teams = self.competition.teams;
    }
}


- (void)viewDidUnload {
    [self setLblName:nil];
    [self setTxtDescription:nil];
    [self setTxtDescription:nil];
    [self setLblSportType:nil];
    [self setLblPlace:nil];
    [self setLblDate:nil];
    [self setLblScores:nil];
    [self setLblTeams:nil];
    [super viewDidUnload];
}
@end
