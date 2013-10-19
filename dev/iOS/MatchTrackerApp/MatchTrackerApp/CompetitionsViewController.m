//
//  CompetitionsViewController.m
//  MatchTrackerApp
//
//  Created by Jesse on 10/01/13.
//  Copyright (c) 2013 Jesse. All rights reserved.
//

#import "CompetitionsViewController.h"
#import <RestKit/RestKit.h>
#import "Competition.h"
#import "Team.h"
#import "Standing.h"
#import "CompetitionsDetailViewController.h"

@interface CompetitionsViewController ()

@end

@implementation CompetitionsViewController
@synthesize competitions;

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
    
    // Load some competitions
    [self loadCompetitions];

    // Uncomment the following line to preserve selection between presentations.
    // self.clearsSelectionOnViewWillAppear = NO;
 
    // Uncomment the following line to display an Edit button in the navigation bar for this view controller.
    // self.navigationItem.rightBarButtonItem = self.editButtonItem;
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

#pragma mark - Table view data source

- (NSInteger)numberOfSectionsInTableView:(UITableView *)tableView
{
    // Return the number of sections.
    return 1;
}

- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
    return self.competitions.count;
}

- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{    
    UITableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:@"CompetitionCell"];
	Competition *competition = [self.competitions objectAtIndex:indexPath.row];
	cell.textLabel.text = [competition name];
	cell.detailTextLabel.text = [competition description];
    return cell;
}


- (void) loadCompetitions
{
    // Create our new Author mapping
    RKObjectMapping* teamMapping = [RKObjectMapping mappingForClass:[Team class] ];
    [teamMapping addAttributeMappingsFromDictionary:@{
     @"id": @"identifier",
     @"name": @"name",
     @"email": @"email",
     }];

    
    // Competition mapping
    RKObjectMapping* articleMapping = [RKObjectMapping mappingForClass:[Competition class]];
    [articleMapping addAttributeMappingsFromDictionary:@{
        @"id": @"identifier",
        @"name": @"name",
        @"description": @"description",
        @"sport_types.name": @"sportType",
        @"startdate": @"startdate",
        @"enddate": @"enddate",
     }];
    
    // Add relationship
    [articleMapping addPropertyMapping:[RKRelationshipMapping relationshipMappingFromKeyPath:@"teams" toKeyPath:@"teams" withMapping:teamMapping]];
    
    RKResponseDescriptor *responseDescriptor = [RKResponseDescriptor responseDescriptorWithMapping:articleMapping pathPattern:nil keyPath:@"leagues" statusCodes:RKStatusCodeIndexSetForClass(RKStatusCodeClassSuccessful)];
    
    NSURL *URL = [NSURL URLWithString:@"http://www.matchtracker.be/api/leagues"];
    NSURLRequest *request = [NSURLRequest requestWithURL:URL];
    RKObjectRequestOperation *objectRequestOperation = [[RKObjectRequestOperation alloc] initWithRequest:request responseDescriptors:@[ responseDescriptor ]];
    [objectRequestOperation setCompletionBlockWithSuccess:^(RKObjectRequestOperation *operation, RKMappingResult *mappingResult) {
        //RKLogInfo(@"Loaded collection of %i Leagues", [mappingResult count]);
        
        // Set data
        self.competitions = [mappingResult array];
        
        // Console print the retrieved competitions
        for(Competition *competition in [mappingResult array]) {
            NSLog(@"Competitie met id=%@ en naam=%@", competition.identifier, [competition name]);
        }
        
        // Reload the table
        [self.tableView reloadData];
        
        // Stop loading
        [self stopLoading];
        
    } failure:^(RKObjectRequestOperation *operation, NSError *error) {
        RKLogError(@"Operation failed with error: %@", error);
    }];
    
    [objectRequestOperation start];
}

// Pull to refresh implementation
- (void)refresh {
    [self performSelector:@selector(loadCompetitions) withObject:nil afterDelay:0];
}




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
    
    
    //CompetitionsDetailViewController *detail = [self.storyboard instantiateViewControllerWithIdentifier:@"CompetitionDetail"];
    //detail.competition = [competitions objectAtIndex:indexPath.row];
    //[self.navigationController pushViewController:detail animated: YES];
    
//    
//    TestTable *detail = [self.storyboard instantiateViewControllerWithIdentifier:@"TestTable"];
//    
//    detail.num = [[NSString stringWithFormat:[heads objectAtIndex:indexPath.row]] intValue];
//    [self.navigationController pushViewController:detail animated: YES];
}

- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender
{
        // Get row index
        NSIndexPath *indexPath = [self.tableView indexPathForSelectedRow];
    
        // Get reference to the destination view controller
        CompetitionsDetailViewController *vc = [segue destinationViewController];
        Competition *competition = [competitions objectAtIndex:indexPath.row];
        
        // Pass any objects to the view controller here, like...
        vc.competition = competition;
}

@end
